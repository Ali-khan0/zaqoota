<?php

namespace App\Http\Requests\Admin;

use App\Models\Module;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class OnboardingInvoiceStoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (!$this->filled('submit_action')) {
            $this->merge(['submit_action' => 'create']);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module_id' => ['required', Rule::exists('modules', 'id')->where(fn ($query) => $query->where('status', 1)->where('module_type', '!=', 'rental'))],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'invoice_type' => ['required', Rule::in(['onboarding', 'other'])],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:invoice_date'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999999999999999.99'],
            'additional_emails' => ['nullable', 'string', 'max:1000'],
            'submit_action' => ['required', Rule::in(['create', 'create_and_send'])],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $store = Store::withoutGlobalScopes()->find($this->integer('store_id'));
            if ($store && $store->module_id !== $this->integer('module_id')) {
                $validator->errors()->add('store_id', translate('The selected store does not belong to this module.'));
            }
            foreach ($this->recipientEmails() as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validator->errors()->add('additional_emails', translate('Enter valid additional email addresses separated by commas.'));
                    break;
                }
            }
            $hasStoreEmail = $store && filter_var($store->email, FILTER_VALIDATE_EMAIL);
            $hasAdditionalEmail = collect($this->recipientEmails())->contains(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
            if ($this->input('submit_action') === 'create_and_send' && !$hasStoreEmail && !$hasAdditionalEmail) {
                $validator->errors()->add('additional_emails', translate('Add at least one valid recipient email before sending the invoice.'));
            }
        }];
    }

    public function recipientEmails(): array
    {
        return collect(preg_split('/[,;]+/', (string) $this->input('additional_emails'), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
