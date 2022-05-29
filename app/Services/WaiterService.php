<?php

namespace App\Services;

use App\Models\CustomerPayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\Waiter;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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

    public function attemptTable(array $tableData): bool
    {
        $table = Table::find($tableData['table_id']);

        if (!$table) {
            throw new Exception('Essa mesa não existe!');
        }

        $orders = $this->formatOrdersRequest($tableData);

        if ($table->status == 'livre') {
            return $this->bookTable($tableData['table_id'], $tableData['clients'], $orders);
        }

        return $this->updateTable($tableData['table_id'], $tableData['clients'], $orders);
    }

    private function bookTable(int $table, int $clients, array $orders): bool
    {
        $newTable = Table::find($table);
        $oldOrders = $newTable->orders;
        foreach ($oldOrders as $order) {
            $order->delete();
        }

        $newTable->status = 'ocupado';
        $newTable->seats_taken = $clients;

        foreach ($orders as $order_id => $qtd) {
            $order = new Order();
            $order->table_id = $table;
            $order->product_id = $order_id;
            $order->product_quantity = $qtd;
            $order->save();
        }

        $newTable->save();

        return true;
    }

    private function updateTable(int $tableId, int $newClientsNum, array $orders): bool
    {
        $table = Table::find($tableId);
        $table->seats_taken = $newClientsNum;

        $ordersModel = $table->orders;
        foreach ($orders as $key => $value) {
            $order = $ordersModel->where('product_id', '=', $key)->first();
            $order->product_quantity = $value;
            $order->save();
        }

        $table->save();

        return true;
    }

    private function formatOrdersRequest(array $requestData): array
    {
        $orders = [];

        foreach ($requestData as $key => $value) {
            if (str_contains($key, 'product')) {
                $id = str_replace('product', '', $key);
                $orders[$id] = $value;
            }
        }

        return $orders;
    }

    public function closeBill(int $tableId, int $totalPrice, array $payments)
    {
        $transaction = new Transaction();
        $transaction->total_price = $totalPrice;
        $transaction->table_id = $tableId;
        $transaction->save();

        $customers = count($payments);
        $customerPayment = $totalPrice / $customers;

        foreach ($payments as $payment) {
            $transaction->customers()->create([
                'payment_method' => $payment,
                'amount_to_pay' => $customerPayment
            ]);
        }

        Table::find($tableId)->update([
            'status' => 'livre',
            'seats_taken' => 0
        ]);
    }

    public function formatPayments(array $requestData)
    {
        $customersPayments = [];

        foreach ($requestData as $key => $value) {
            if (str_contains($key, 'client')) {
                $id = str_replace('client', '', $key);
                $customersPayments[$id] = $value;
            }
        }

        return $customersPayments;
    }

    public function logout(): void
    {
        Auth::guard('waiter')->logout();
    }

    public function getAllTables(): Collection
    {
        return Table::all();
    }

    public function getTable(string $id): Table
    {
        return Table::find($id);
    }

    public function getAllProducts(): Collection
    {
        return Product::all();
    }
}
