<?php

namespace App\Services;

use App\Mail\OnboardingInvoiceMail;
use App\Mail\VendorSelfRegistration;
use App\Models\OnboardingInvoice;
use App\Models\OnboardingInvoiceDelivery;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class OnboardingInvoiceDeliveryService
{
    public function send(
        OnboardingInvoice $invoice,
        string $deliveryType,
        ?array $selectedRecipients = null,
        ?int $actorAdminId = null,
        ?string $actorName = null,
        ?string $idempotencyKey = null,
    ): array {
        $allowedRecipients = collect([$invoice->store_email, ...($invoice->recipient_emails ?? [])])
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();
        $recipients = $selectedRecipients === null
            ? $allowedRecipients
            : $allowedRecipients->intersect($selectedRecipients)->values();

        return $this->deliver(
            invoice: $invoice,
            deliveryType: $deliveryType,
            recipients: $recipients,
            mailable: fn () => new OnboardingInvoiceMail($invoice->loadMissing('items'), $deliveryType),
            actorAdminId: $actorAdminId,
            actorName: $actorName,
            idempotencyKey: $idempotencyKey,
            updateInvoiceStatus: true,
        );
    }

    public function sendRegistration(
        OnboardingInvoice $invoice,
        string $recipient,
        string $storeName,
        ?int $actorAdminId = null,
        ?string $actorName = null,
        ?string $idempotencyKey = null,
    ): array {
        return $this->deliver(
            invoice: $invoice,
            deliveryType: 'registration',
            recipients: collect([$recipient])->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL)),
            mailable: fn () => new VendorSelfRegistration('pending', $storeName),
            actorAdminId: $actorAdminId,
            actorName: $actorName,
            idempotencyKey: $idempotencyKey,
            updateInvoiceStatus: false,
        );
    }

    private function deliver(
        OnboardingInvoice $invoice,
        string $deliveryType,
        Collection $recipients,
        callable $mailable,
        ?int $actorAdminId,
        ?string $actorName,
        ?string $idempotencyKey,
        bool $updateInvoiceStatus,
    ): array {
        if ($recipients->isEmpty()) {
            $message = translate('The store does not have a valid email address.');
            if ($updateInvoiceStatus) {
                $invoice->update([
                    'send_status' => OnboardingInvoice::SEND_FAILED,
                    'last_send_error' => $message,
                ]);
            }

            return ['sent' => 0, 'failed' => 0, 'skipped' => 0, 'error' => $message];
        }

        $sent = 0;
        $failed = 0;
        $skipped = 0;
        $lastError = null;
        $keyHash = $idempotencyKey === null ? null : hash('sha256', $idempotencyKey);
        foreach ($recipients as $recipient) {
            $delivery = $this->deliveryRecord($invoice, $recipient, $deliveryType, $keyHash);
            if ($keyHash !== null && $delivery->exists && $delivery->status === 'sent') {
                $skipped++;

                continue;
            }

            $delivery->fill([
                'status' => 'processing',
                'attempt_count' => ((int) $delivery->attempt_count) + 1,
                'error_message' => null,
                'sent_by' => $actorAdminId,
                'sent_by_name' => $actorName,
                'last_attempt_at' => now(),
            ])->save();

            try {
                Mail::to($recipient)->send($mailable());
                $delivery->update([
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => now(),
                ]);
                $sent++;
            } catch (\Throwable $exception) {
                report($exception);
                $lastError = mb_substr($exception->getMessage(), 0, 2000);
                $delivery->update([
                    'status' => 'failed',
                    'error_message' => $lastError,
                ]);
                $failed++;
            }
        }

        $delivered = $sent + $skipped;
        if ($updateInvoiceStatus) {
            $invoice->update([
                'send_status' => $delivered > 0 ? OnboardingInvoice::SEND_SENT : OnboardingInvoice::SEND_FAILED,
                'sent_at' => $delivered > 0 ? ($invoice->sent_at ?? now()) : $invoice->sent_at,
                'last_send_error' => $failed > 0 ? $lastError : null,
            ]);
        }
        $invoice->events()->create([
            'event_type' => $deliveryType.'_delivery',
            'description' => ucfirst($deliveryType)." delivery processed for {$recipients->count()} recipient(s).",
            'metadata' => [
                'sent' => $sent,
                'failed' => $failed,
                'skipped_as_already_sent' => $skipped,
                'queued_retry' => $keyHash !== null,
            ],
            'admin_id' => $actorAdminId,
            'admin_name' => $actorName,
        ]);

        return ['sent' => $sent, 'failed' => $failed, 'skipped' => $skipped, 'error' => $lastError];
    }

    private function deliveryRecord(
        OnboardingInvoice $invoice,
        string $recipient,
        string $deliveryType,
        ?string $keyHash,
    ): OnboardingInvoiceDelivery {
        if ($keyHash === null) {
            return $invoice->deliveries()->make([
                'recipient_email' => $recipient,
                'delivery_type' => $deliveryType,
            ]);
        }

        return $invoice->deliveries()->firstOrNew([
            'recipient_email' => $recipient,
            'delivery_type' => $deliveryType,
            'idempotency_key_hash' => $keyHash,
        ]);
    }
}
