<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
</head>
<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial, Helvetica, sans-serif;">

    <div style="max-width:680px;margin:0 auto;padding:24px;">

        <div style="background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.06);">

            <div style="background:#111827;color:#ffffff;padding:20px 24px;">
                <div style="font-size:18px;font-weight:700;">Kiana Furniture</div>
                <div style="font-size:13px;opacity:.9;margin-top:4px;">Update Status Pesanan</div>
            </div>

            <div style="padding:22px 24px;">
                <p style="margin:0 0 14px;color:#111827;font-size:14px;line-height:1.6;">
                    Halo <strong>{{ $order->fullname }}</strong>,
                    status pesanan Anda saat ini telah diperbarui.
                </p>

                <div style="border:1px solid #e5e7eb;border-radius:12px;padding:16px;margin:16px 0;">

                    <div style="font-size:13px;color:#6b7280;margin-bottom:10px;">Ringkasan</div>

                    <table style="width:100%;border-collapse:collapse;font-size:14px;">
                        <tbody>
                            <tr>
                                <td style="padding:6px 0;color:#6b7280;width:180px;">ID Order</td>
                                <td style="padding:6px 0;color:#111827;">#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#6b7280;">Nomor Invoice / Order Number</td>
                                <td style="padding:6px 0;color:#111827;">{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#6b7280;">Status Terbaru</td>
                                <td style="padding:6px 0;color:#111827;">
                                    {{ ucfirst(str_replace(['_', '-'], ' ', $order->status)) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#6b7280;">Total Order</td>
                                <td style="padding:6px 0;color:#111827;">
                                    Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;color:#6b7280;">Tanggal Order</td>
                                <td style="padding:6px 0;color:#111827;">
                                    {{ optional($order->created_at)->format('d M Y H:i') }}
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <div style="margin:16px 0;">
                    <div style="font-size:13px;color:#6b7280;margin-bottom:10px;">Detail Customer</div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:14px;">
                        <p style="margin:0 0 8px;font-size:14px;color:#111827;">
                            <strong>{{ $order->fullname }}</strong>
                        </p>
                        <p style="margin:0 0 8px;font-size:13px;color:#111827;">
                            Email: {{ $order->email ?? '-' }}
                        </p>
                        <p style="margin:0;font-size:13px;color:#111827;">
                            Phone: {{ $order->phone }}
                        </p>
                    </div>
                </div>

                <div style="border-left:4px solid #10b981;background:#ecfdf5;padding:12px 14px;border-radius:10px;">
                    <div style="font-size:13px;color:#065f46;font-weight:700;margin-bottom:6px;">Pesan</div>
                    <div style="font-size:14px;color:#064e3b;line-height:1.6;">
                        {!! nl2br(e($message)) !!}
                    </div>
                </div>

                <div style="margin-top:22px;padding-top:14px;border-top:1px solid #e5e7eb;">
                    <p style="margin:0;color:#6b7280;font-size:12px;line-height:1.6;">
                        Terima kasih telah berbelanja di <strong>Kiana Furniture</strong>.<br>
                        Jika membutuhkan bantuan, balas email ini.
                    </p>

                    <p style="margin:10px 0 0;color:#9ca3af;font-size:12px;">
                        Kiana Furniture
                    </p>
                </div>
            </div>

        </div>

        <div style="text-align:center;margin-top:14px;color:#9ca3af;font-size:12px;">
            Email ini dikirim otomatis dari sistem Kiana Furniture.
        </div>

    </div>

</body>
</html>

