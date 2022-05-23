<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class WaiterService
{
    public function attemptAuthentication(array $credentials): void
    {
        $waiter = User::where('email', '=', $credentials['email'])->first();

        if (!$waiter || $waiter->acc_type != 'waiter') {
            throw new Exception('Essa conta não existe!');
        }

        if (!Auth::attempt($credentials)) {
            throw new Exception('Senha incorreta!');
        }
    }
}
