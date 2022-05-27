<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableModal;
use App\Http\Requests\WaiterAuthentication;
use App\Services\WaiterService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $tables = $this->service->getAllTables();
        $products = $this->service->getAllProducts();

        return view('waiter.dashboard-page', [
            'tables' => $tables,
            'products' => $products
        ]);
    }

//    public function getTablePage(Request $request): RedirectResponse|View
//    {
//        // mudar essa porra aqui caralho
//        $id = $request->table_id;
//        $table = $this->service->getTable($id);
//
//        if ($table) {
//            return view('waiter.table', [
//                'table' => $table
//            ]);
//        }
//
//        return back();
//    }

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

    public function postDashboard(TableModal $request)
    {
        $tableData = $request->validated();

        try {
            $this->service->attemptTable($tableData);
            return $this->getDashboardPage();
        } catch (Exception $exception) {
            return back()->withErrors([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function getLogout(): RedirectResponse
    {
        $this->service->logout();
        return redirect('/login');
    }
}
