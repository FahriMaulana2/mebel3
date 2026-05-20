<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsAppService
{
    private const ENDPOINT = 'https://api.fonnte.com/send';

    /**
     * Validasi nomor WhatsApp Indonesia.
     * Menerima format:
     * - 08xxxxxxxxxx
     * - 62xxxxxxxxxx
     */
    public function isValidIndonesiaPhone(?string $phone): bool
    {
        if (!$phone) {
            return false;
        }

        $normalized = $this->normalizePhone($phone);

        // 08 + 8..12 digit  | 62 + 8..12 digit
        return (bool) preg_match('/^(08\d{8,12}|62\d{8,12})$/', $normalized);
    }

    /**
     * Normalisasi menjadi format countryCode 62 tanpa '+' (mis: 62812xxxx).
     */
    public function normalizeToCountryCode62(string $phone): string
    {
        $normalized = $this->normalizePhone($phone);

        if (Str::startsWith($normalized, '08')) {
            return '62' . substr($normalized, 2);
        }

        if (Str::startsWith($normalized, '62')) {
            return $normalized;
        }

        return $normalized;
    }

    /**
     * Kirim WhatsApp menggunakan Fonnte API.
     */
    public function send(string $target, string $message, string $countryCode = '62'): void
    {
        $token = env('FONNTE_TOKEN');
        if (!$token) {
            // Fail-safe: jangan sampai update order crash jika token belum ada
            return;
        }

        Http::withHeaders([
            'Authorization' => $token,
        ])->timeout(20)
            ->post(self::ENDPOINT, [
                'target' => $target,
                'message' => $message,
                'countryCode' => $countryCode,
            ])->throw();
    }

    /**
     * Buat pesan WhatsApp berdasarkan status order.
     * Pastikan message berupa plain text (tanpa HTML) untuk keamanan.
     */
    public function messageForStatus(array $orderData, string $status): string
    {
        $customerName = (string) ($orderData['customer_name'] ?? '');
        $invoiceNumber = (string) ($orderData['invoice_number'] ?? '');

        $greeting = $customerName !== '' ? "Halo {$customerName}," : 'Halo,';

        $statusLabel = match ($status) {
            'pending' => 'Menunggu Diproses',
            'processed' => 'Pesanan Diproses',
            'shipped' => 'Pesanan Dikirim',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Pesanan Dibatalkan',
            default => ucfirst($status),
        };

        $closing = 'Terima kasih telah berbelanja di Kiana Furniture.';

        return match ($status) {
            'pending' => "{$greeting}\n\nTerima kasih telah melakukan pemesanan.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nKami akan segera memproses pesanan Anda.\n{$closing}",
            'processed' => "{$greeting}\n\nPesanan Anda sedang diproses.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nTim kami sedang menyiapkan pesanan Anda.\n{$closing}",
            'shipped' => "{$greeting}\n\nPesanan Anda sudah dikirim.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nSilakan menunggu kedatangan.\n{$closing}",
            'completed' => "{$greeting}\n\nPesanan Anda telah selesai.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nTerima kasih atas kepercayaan Anda.\n{$closing}",
            'cancelled' => "{$greeting}\n\nMaaf, pesanan Anda dibatalkan.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nJika membutuhkan bantuan, silakan hubungi kami.\n{$closing}",
            default => "{$greeting}\n\nUpdate status pesanan Anda.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\n{$closing}",
        };
    }

    private function normalizePhone(string $phone): string
    {
        // hapus spasi/dash/bracket
        return preg_replace('/[\s\-()]/', '', $phone);
    }
}

