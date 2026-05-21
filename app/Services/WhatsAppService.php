<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsAppService
{
    private const ENDPOINT = 'https://api.fonnte.com/send';

    /*
    |--------------------------------------------------------------------------
    | VALIDASI NOMOR INDONESIA
    |--------------------------------------------------------------------------
    */
    public function isValidIndonesiaPhone(?string $phone): bool
    {
        if (!$phone) {
            return false;
        }

        $normalized = $this->normalizePhone($phone);

        // valid: 08xxxxxxxxxx atau 62xxxxxxxxxx
        return (bool) preg_match('/^(08\d{8,12}|62\d{8,12})$/', $normalized);
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI KE FORMAT 62
    |--------------------------------------------------------------------------
    */
    public function normalizeToCountryCode62(string $phone): string
    {
        $phone = $this->normalizePhone($phone);

        // 08xxxx -> 62xxxx
        if (Str::startsWith($phone, '08')) {
            return '62' . substr($phone, 2);
        }

        // sudah 62
        if (Str::startsWith($phone, '62')) {
            return $phone;
        }

        return $phone;
    }

    /*
    |--------------------------------------------------------------------------
    | KIRIM WHATSAPP VIA FONNTE
    |--------------------------------------------------------------------------
    */
    public function send(string $target, string $message, string $countryCode = '62'): bool
    {
        try {
            $token = env('FONNTE_TOKEN');

            if (!$token) {
                return false;
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(20)
              ->post(self::ENDPOINT, [
                  'target' => $target,
                  'message' => $message,
                  'countryCode' => $countryCode,
              ]);

            return $response->successful();

        } catch (\Throwable $e) {
            // jangan sampai crash sistem order
            logger()->error('Fonnte Error: ' . $e->getMessage());

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PESAN BERDASARKAN STATUS ORDER
    |--------------------------------------------------------------------------
    */
    public function messageForStatus(array $orderData, string $status): string
    {
        $customerName  = $orderData['customer_name'] ?? '';
        $invoiceNumber = $orderData['invoice_number'] ?? '';

        $greeting = $customerName
            ? "Halo {$customerName},"
            : "Halo,";

        $statusLabel = match ($status) {
            'pending'   => 'Menunggu Diproses',
            'processed' => 'Pesanan Diproses',
            'shipped'   => 'Pesanan Dikirim',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Pesanan Dibatalkan',
            default     => ucfirst($status),
        };

        $closing = "Terima kasih telah berbelanja di Kiana Furniture.";

        return match ($status) {
            'pending' => "{$greeting}\n\nTerima kasih telah melakukan pemesanan.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nKami akan segera memproses pesanan Anda.\n\n{$closing}",

            'processed' => "{$greeting}\n\nPesanan Anda sedang diproses.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nTim kami sedang menyiapkan pesanan Anda.\n\n{$closing}",

            'shipped' => "{$greeting}\n\nPesanan Anda sudah dikirim.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nSilakan menunggu kedatangan.\n\n{$closing}",

            'completed' => "{$greeting}\n\nPesanan Anda telah selesai.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nTerima kasih atas kepercayaan Anda.\n\n{$closing}",

            'cancelled' => "{$greeting}\n\nMaaf, pesanan Anda dibatalkan.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\nJika membutuhkan bantuan, silakan hubungi kami.\n\n{$closing}",

            default => "{$greeting}\n\nUpdate status pesanan Anda.\nInvoice: {$invoiceNumber}\nStatus: {$statusLabel}\n\n{$closing}",
        };
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE INTERNAL
    |--------------------------------------------------------------------------
    */
    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[\s\-()]/', '', $phone);
    }
}