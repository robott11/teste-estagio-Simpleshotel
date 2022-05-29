<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableModal;
use App\Http\Requests\WaiterAuthentication;
use App\Models\Product;
use App\Models\Table;
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

    public function getCloseBillPage(Request $request): View
    {
        $tableId = $request->table_id;

        $table = Table::find($tableId);
        $tableOrders = $table->orders->where('table_id', '=', $tableId)->where('product_quantity', '>', 0);

        $products = Product::all();
        $totalPrice = 0;
        foreach ($tableOrders as $tableOrder) {
            $qtd = $tableOrder->product_quantity;
            $totalPrice += $products->find($tableOrder->product_id)->price * $qtd;
        }

        return view('waiter.closeBill', [
            'table' => $table,
            'tableOrders' => $tableOrders,
            'totalPrice' => $totalPrice
        ]);
    }

    public function getLogout(): RedirectResponse
    {
        $this->service->logout();
        return redirect('/login');
    }

    public function postCloseBill(Request $request)
    {
        $requestData = $request->input();
        $customersPayments = $this->service->formatPayments($requestData);

        $this->service->closeBill($request->table_id, $request->total_price, $customersPayments);

        return redirect('/dashboard');
    }
}
