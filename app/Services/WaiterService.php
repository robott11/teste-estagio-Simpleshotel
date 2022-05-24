<?php

namespace App\Services;

use App\Models\Waiter;
use Exception;
use Illuminate\Support\Facades\Auth;

class WaiterService
{
    public function attemptAuthentication(array $credentials): void
    {
        $waiter = Waiter::where('email', '=', $credentials['email'])->first();

        if (!$waiter) {
            throw new Exception('Essa conta não existe!');
        }

        if (!Auth::guard('waiter')->attempt($credentials)) {
            throw new Exception('Senha incorreta!');
        }
    }

    public function logout(): void
    {
        Auth::guard('waiter')->logout();
    }
}
