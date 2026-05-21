<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public string $statusMessage;

    public function __construct(Order $order, string $statusMessage)
    {
        $this->order = $order;
        $this->statusMessage = $statusMessage;
    }

    public function build(): self
    {
        $invoice = (string) ($this->order->order_number ?? '');

        return $this
            ->subject("[Kiana Furniture] Update Order {$invoice}")
            ->view('emails.order-status-updated')
            ->with([
                'statusMessage' => $this->statusMessage,
            ]);
    }
}