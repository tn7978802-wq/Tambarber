<?php

namespace App\Http\Requests\Inventory;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function prepareForValidation(): void
    {
        $phone = trim((string) $this->input('phone', ''));

        $this->merge([
            'fullname' => trim((string) $this->input('fullname', '')),
            'email' => strtolower(trim((string) $this->input('email', ''))),
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    public function rules(): array
    {
        $account = $this->route('account');
        $account = $account instanceof User ? $account : null;

        $uniquePhone = Rule::unique('users', 'phone');
        if ($account) {
            $uniquePhone->ignore($account);
        }
        $uniqueEmail = function (string $attribute, mixed $value, \Closure $fail) use ($account): void {
            $query = User::query()->whereRaw('LOWER(email) = ?', [strtolower($value)]);
            if ($account) {
                $query->where('id', '<>', $account->id);
            }

            if ($query->exists()) {
                $fail('Email này đã được sử dụng.');
            }
        };

        $ownerEmails = array_filter(array_map(
            'trim',
            explode(',', strtolower(config('app.system_owner_email', ''))),
        ));
        $subOwnerEmails = DB::table('sub_owners')->pluck('email')
            ->map(fn (string $email): string => strtolower($email))
            ->all();
        $reservedEmails = array_values(array_unique(array_merge($ownerEmails, $subOwnerEmails)));
        $allowedRoles = $this->user()->isSystemOwner()
            ? [User::ROLE_CLIENT, User::ROLE_ADMIN]
            : [User::ROLE_CLIENT];

        return [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                $uniqueEmail,
                Rule::notIn($reservedEmails),
            ],
            'phone' => ['nullable', 'string', 'max:20', $uniquePhone],
            'admin_role' => ['required', 'integer', Rule::in($allowedRoles)],
            'is_active' => ['required', 'boolean'],
            'password' => $account
                ? ['nullable', 'string', 'min:8', 'confirmed']
                : ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
