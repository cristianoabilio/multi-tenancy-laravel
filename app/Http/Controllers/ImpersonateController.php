<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function impersonate($userId)
    {
        $originalUserId = auth::user()->id;
        session()->put('impersonate', $originalUserId);

        Auth::loginUsingId($userId);

        return redirect()->route('clients.index');
    }

    public function leaveImpersonate()
    {
        if (! session()->has('impersonate')) {
            abort(403);
        }

        Auth::loginUsingId(session()->get('impersonate'));
        session()->remove('impersonate');
        session()->remove('company_id');

        return redirect()->route('dashboard');

    }


}
