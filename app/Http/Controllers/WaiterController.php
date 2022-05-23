<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaiterAuthentication;
use App\Services\WaiterService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WaiterController extends Controller
{
    private WaiterService $service;

    public function __construct(WaiterService $service)
    {
        $this->service = $service;
    }

    public function getLoginPage(): View
    {
        return view('waiter.login-page');
    }

    public function postLogin(WaiterAuthentication $request)
    {
        $credentials = $request->validated();

        try {
            $this->service->attemptAuthentication($credentials);
            dd('deu boa'); // todo: all the other pages. And change the time zone
        } catch (Exception $exception) {
            return back()->withErrors([
                'status' => $exception->getMessage()
            ])->withInput(['email' => $credentials['email']]);
        }
    }
}
