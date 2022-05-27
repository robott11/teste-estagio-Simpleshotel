@extends('templates.dashboard-template')
@section('title', 'Fechar Conta')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Mesa {{ $table->id }}</h1>

            <hr>

            <a href="{{ route('waiterDashboard') }}">
                <button type="button" class="btn btn-warning">Voltar</button>
            </a>

            <hr>

            <form method="POST">
                @csrf

                <h2>Clientes: <strong>{{ $table->seats_taken }}</strong></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quatidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tableOrders as $order)
                        <tr>
                            <th scope="row">{{ \App\Models\Product::find($order->product_id)->name }}</th>
                            <td>
                                R$ {{ number_format(\App\Models\Product::find($order->product_id)->price / 100, 2, ',') }}
                            </td>
                            <td>{{ $order->product_quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="row">
                    <div class="col"><h2>Valor Total: R$ {{ number_format($totalPrice / 100, 2, ',') }}</h2></div>
                    <div class="col"><h2>Valor por cliente: R$ {{ number_format(($totalPrice / 100) / $table->seats_taken, 2, ',') }}</h2></div>
                </div>
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <button class="btn btn-success btn-lg" style="width: 70%">Fechar</button>
                    </div>
                    <div class="col">
                        <div class="row my-4">
                        @for($i = 1; $i <= $table->seats_taken; $i++)
                            <div class="col-3">
                                <label for="selectPayment{{ $i }}"><strong>Cliente</strong> {{ $i }}</label>
                                <select name="" class="form-select" id="selectPayment{{ $i }}">
                                    <option value="dinheiro">Dinheiro</option>
                                    <option value="debito">Débito</option>
                                    <option value="credito">Crédito</option>
                                    <option value="pix">Pix</option>
                                </select>
                            </div>
                        @endfor
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
