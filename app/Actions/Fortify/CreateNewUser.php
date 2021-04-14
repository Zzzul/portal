<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            /**
              *  2  = organizer
              *  3 = audience
              */
            'role' => 'required|numeric|in:2,3',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole($input['role']);
        if ($input['role'] == 2) {
            // for organizer
            $user->givePermissionTo([
                'event index', 'event create', 'event store', 'event show', 'event edit', 'event update', 'event delete', 'event update payment status', 'event check payment status', 'event book', 'event history',
                'performer index', 'performer create', 'performer store', 'performer edit',
                'performer update', 'performer delete',
                'setting'
            ]);
        } else {
            // for audience
            $user->givePermissionTo(['event book', 'event history', 'setting']);
        }


        return $user;
    }
}
