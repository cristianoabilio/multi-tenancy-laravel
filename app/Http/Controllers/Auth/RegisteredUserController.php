<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\Seller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();

            $company = Company::create([
                'name' => $request->company,
                'commission_rate' => Company::COMPANY_COMMISSION_RATE_DEFAULT
            ]);

            $user = User::create([
                'name' => $request->name,
                'role_id' => RoleEnum::MANAGER,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $seller = Seller::create([
                'company_id' => $company->id,
                'user_id' => $user->id
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Problem to create a new user.');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
