<?php

namespace App\Http\Requests\Inventory;

use App\Models\InventoryTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryTransactionRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $items = $this->input('items', []);
        if (! is_array($items)) {
            return;
        }

        foreach ($items as &$item) {
            if (! is_array($item)) {
                continue;
            }

            if (isset($item['serial_numbers']) && is_string($item['serial_numbers'])) {
                $item['serial_numbers'] = array_values(array_filter(array_map(
                    'trim',
                    preg_split('/[\r\n,;]+/', $item['serial_numbers']) ?: [],
                )));
            }
        }
        unset($item);

        $this->merge(['items' => $items]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $quantityRules = $this->input('type') === InventoryTransaction::TYPE_ADJUSTMENT
            ? ['required', 'decimal:0,3', 'not_in:0']
            : ['required', 'decimal:0,3', 'gt:0'];

        return [
            'type' => ['required', Rule::in([
                InventoryTransaction::TYPE_IMPORT,
                InventoryTransaction::TYPE_EXPORT,
                InventoryTransaction::TYPE_ADJUSTMENT,
            ])],
            'project_or_supplier_name' => ['required_if:type,adjustment', 'nullable', 'string', 'max:255'],
            'supplier_id' => ['required_if:type,import', 'nullable', 'integer', 'exists:suppliers,id'],
            'project_id' => ['required_if:type,export', 'nullable', 'integer', 'exists:projects,id'],
            'transaction_date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:5000'],
            'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*' => ['required', 'array'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => array_merge($quantityRules, ['max:99999999999.999']),
            'items.*.unit_price' => ['nullable', 'decimal:0,2', 'min:0', 'max:999999999999.99'],
            'items.*.serial_numbers' => ['nullable', 'array', 'max:100'],
            'items.*.serial_numbers.*' => ['string', 'max:255'],
        ];
    }
}
