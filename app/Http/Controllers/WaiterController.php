<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaiterAuthentication;
use App\Services\WaiterService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WaiterController extends Controller
{
    private WaiterService $service;

    public function __construct(WaiterService $service)
    {
        $this->middleware('waiter.check');
        $this->service = $service;
    }

    public function getLoginPage(): View
    {
        return view('waiter.login-page');
    }

    public function getDashboardPage(): View
    {
        return view('waiter.dashboard-page');
    }

    public function postLogin(WaiterAuthentication $request): RedirectResponse
    {
        $credentials = $request->validated();

        try {
            $this->service->attemptAuthentication($credentials);
            return redirect('/dashboard');
        } catch (Exception $exception) {
            return back()->withErrors([
                'status' => $exception->getMessage()
            ])->withInput(['email' => $credentials['email']]);
        }
    }

    public function getLogout(): RedirectResponse
    {
        $this->service->logout();
        return redirect('/login');
    }
}
