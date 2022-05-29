@extends('templates.admin-template')
@section('title', 'Admin - Caixa')

@section('content')
    <div class="row">
        <div class="col">
            <table class="table table-hover">
                <thead>
                <tr class="table-info">
                    <th class="col">Mesa</th>
                    <th class="col">Valor Total</th>
                    <th class="col">Clientes</th>
                    <th class="col">Valor por Cliente</th>
                    <th class="col">Data</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr class="table-success">
                        <td>{{ $transaction->table_id }}</td>
                        <td>R$ {{ number_format($transaction->total_price / 100, 2, ',') }}</td>
                        <td>{{ count($customerPayments->where('transaction_id', '=', $transaction->id)) }}</td>
                        <td>R$ {{ number_format(($transaction->total_price / count($customerPayments->where('transaction_id', '=', $transaction->id)) ) / 100, 2, ',') }}</td>
                        <td>{{ date_format($transaction->created_at, 'd/m/Y H:i:s') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
