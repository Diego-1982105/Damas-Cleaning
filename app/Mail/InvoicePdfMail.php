<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Support\InvoicePdfFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice #'.$this->invoice->id.' — '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '<p style="font-family: sans-serif; font-size: 14px;">Please find your invoice attached as a PDF.</p>',
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $id = $this->invoice->getKey();
        $name = 'Damas-Invoice-'.$id.'.pdf';

        return [
            Attachment::fromData(function () use ($id): string {
                $invoice = Invoice::query()->findOrFail($id);

                return InvoicePdfFactory::make($invoice)->output();
            }, $name)
                ->withMime('application/pdf'),
        ];
    }
}
