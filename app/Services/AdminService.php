<?php

namespace App\Services;

use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    public function attemptAuthentication(array $credentials): void
    {
        $waiter = Admin::where('email', '=', $credentials['email'])->first();

        if (!$waiter) {
            throw new Exception('Essa conta não existe!');
        }

        if (!Auth::guard('admin')->attempt($credentials)) {
            throw new Exception('Senha incorreta!');
        }
    }

    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }
}
