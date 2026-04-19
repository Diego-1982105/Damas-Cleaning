<?php

namespace Tests\Feature;

use App\Mail\InvoicePdfMail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvoicePdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_download_invoice_pdf(): void
    {
        $client = Client::query()->create([
            'name' => 'Test Client',
            'address' => "1 Main St\nCity, ST 12345",
        ]);
        $invoice = Invoice::query()->create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'status' => 'draft',
            'total' => 0,
        ]);
        InvoiceItem::query()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Cleaning',
            'quantity' => 1,
            'price' => 50,
            'total' => 50,
            'sort_order' => 0,
        ]);
        $invoice->recalculateTotal();

        $this->get(route('admin.facturas.pdf', $invoice))
            ->assertRedirect(route('admin.login'));
        $this->get(route('admin.facturas.pdf.preview', $invoice))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_download_invoice_pdf(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
            'permissions' => ['manage_invoices'],
        ]);

        $client = Client::query()->create([
            'name' => 'Georgia Sewer and Storm LLC',
            'address' => "363 West water RGD\nSugar Hill, GA 30024",
        ]);
        $invoice = Invoice::query()->create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'status' => 'paid',
            'total' => 0,
        ]);
        InvoiceItem::query()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Deep cleaning',
            'quantity' => 1,
            'price' => 500,
            'total' => 500,
            'sort_order' => 0,
        ]);
        $invoice->recalculateTotal();

        $response = $this->actingAs($user)->get(route('admin.facturas.pdf', $invoice));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', (string) $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function test_admin_can_stream_invoice_pdf_preview(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
            'permissions' => ['manage_invoices'],
        ]);

        $client = Client::query()->create(['name' => 'ACME', 'email' => 'billing@acme.test']);
        $invoice = Invoice::query()->create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'status' => 'draft',
            'total' => 0,
        ]);
        InvoiceItem::query()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Service',
            'quantity' => 1,
            'price' => 10,
            'total' => 10,
            'sort_order' => 0,
        ]);
        $invoice->recalculateTotal();

        $response = $this->actingAs($user)->get(route('admin.facturas.pdf.preview', $invoice));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', (string) $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function test_admin_can_send_invoice_pdf_by_email(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'staff',
            'permissions' => ['manage_invoices'],
        ]);

        $client = Client::query()->create(['name' => 'ACME', 'email' => 'client@acme.test']);
        $invoice = Invoice::query()->create([
            'client_id' => $client->id,
            'date' => now()->toDateString(),
            'status' => 'draft',
            'total' => 0,
        ]);
        InvoiceItem::query()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Service',
            'quantity' => 1,
            'price' => 10,
            'total' => 10,
            'sort_order' => 0,
        ]);
        $invoice->recalculateTotal();

        $this->actingAs($user)
            ->post(route('admin.facturas.pdf.email', $invoice), ['email' => 'recipient@acme.test'])
            ->assertRedirect(route('admin.facturas.show', $invoice))
            ->assertSessionHas('status');

        Mail::assertSent(InvoicePdfMail::class, function (InvoicePdfMail $mail): bool {
            return $mail->hasTo('recipient@acme.test');
        });
    }
}
