<?php

namespace App\Livewire\Forms;

use App\Enums\RoleEnum;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SellerForm extends Form
{
    public Seller $seller;
    public $name = '';
    public $email = '';
    public $role_id = RoleEnum::MANAGER->value;
    public $password = '';
    public $password_confirmation = '';

    public function setSeller(Seller $seller)
    {
        $this->seller = $seller;

        if (! empty($this->seller->user)) {
            $this->name = $seller->user->name;
            $this->email = $seller->user->email;
            $this->role_id = $seller->user->role_id;
        }
    }

    public function save()
    {
        $emailValidation = ['required', 'email', 'unique:users'];
        $method = 'create';

        if (! empty($this->seller->user)) {
            $emailValidation = ['required', 'email', Rule::unique('users')->ignore($this->seller->user_id)];
            $method = 'update';
        }
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailValidation,
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required'],
        ]);

        try {
            switch ($method)
            {
                case 'update':
                    $this->seller->user->update($this->only(['name', 'email', 'password', 'role_id']));
                    $message = 'Seller updated successfully';
                break;

                case 'create':
                    User::create(
                        $this->only(['name', 'email', 'password', 'role_id'])
                    )->seller()->create();
                    $message = 'Seller created successfully';
                break;
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Problem creating/updating seller');
        }


        return redirect()->route('sellers.index')->with('success', $message);
    }
}
