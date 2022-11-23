<?php

namespace App\Actions\Fortify;

use App\Models\Company;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @param array $input
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'company_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $company = Company::updateOrCreate(['name' => $input['company_name']]);
        $ownerRole = Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Owner', 'order' => 1, 'status' => 1, 'slug' => 'owner']);
//        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Admin', 'order' => 1, 'status' => 1, 'slug' => 'admin']);
        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'Billing', 'order' => 1, 'status' => 1, 'slug' => 'billing']);
        Role::firstOrCreate(['company_id' => $company->id, 'role' => 'User', 'order' => 1, 'status' => 1, 'slug' => 'user']);

        return User::create([
            'name' => $input['name'],
            'company_id' => $company->id,
            'email' => $input['email'],
            'is_owner' => 1,
            'role_id' => $ownerRole->id,
            'password' => Hash::make($input['password']),
        ]);
    }
}
