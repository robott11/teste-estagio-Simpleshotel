<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAuthentication;
use App\Http\Requests\TableModal;
use App\Models\Product;
use App\Models\Table;
use App\Services\AdminService;
use App\Services\WaiterService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    private AdminService $service;
    private WaiterService $waiterService;

    public function __construct(AdminService $service, WaiterService $waiterService)
    {
        $this->middleware('admin.check');
        $this->service = $service;
        $this->waiterService = $waiterService;
    }

    public function getLoginPage(): View
    {
        return view('admin.login-page');
    }

    public function getAdminDashboardPage()
    {
        $tables = Table::all();
        $products = Product::all();

        return view('admin.dashboard-page', [
            'tables' => $tables,
            'products' => $products
        ]);
    }

    public function postDashboard(TableModal $request)
    {
        $tableData = $request->validated();

        try {
            $this->waiterService->attemptTable($tableData);
            return $this->getAdminDashboardPage();
        } catch (Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function postLogin(AdminAuthentication $request)
    {
        $credentials = $request->validated();

        try {
            $this->service->attemptAuthentication($credentials);
            return redirect('/admin/dashboard');
        } catch (Exception $exception) {
            return back()->withErrors([
                'status' => $exception->getMessage()
            ])->withInput(['email' => $credentials['email']]);
        }
    }

    public function getLogout()
    {
        $this->service->logout();
        return redirect()->route('adminLogin');
    }
}
