@extends('templates.admin-template')
@section('title', 'Admin - Dashboard')

@section('content')
    <div class="row">
        @foreach($tables as $table)
            <div class="col-md-3">
                <div class="card text-white @if($table->status != 'livre') bg-danger @else bg-success @endif my-2">
                    <div class="card-header">Mesa {{ $table->id }} - <strong>Status: {{ $table->status }}</strong></div>
                    <div class="card-body">
                        <strong>Cadeiras ocupadas:</strong> {{ $table->seats_taken }} / {{ $table->max_seats }}<br>

                        <hr>

                        <button class="btn @if($table->status != 'livre') btn-warning @else btn-info @endif"
                                data-bs-toggle="modal" data-bs-target="#tableModal{{ $table->id }}">
                            Info
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="tableModal{{ $table->id }}" tabindex="-1"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered text-black">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Mesa {{ $table->id }}</h5>
                                    <span
                                        class="badge @if($table->status != 'livre') bg-danger @else bg-success @endif ms-3">
                                        @if($table->status != 'livre')
                                            Ocupado
                                        @else
                                            Livre
                                        @endif
                                    </span>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <input type="hidden" name="table_id" value="{{ $table->id }}">

                                    <strong>Clientes: </strong>

                                    @for($i = 1; $i <= $table->max_seats; $i++)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="clients"
                                                   id="modalRadio{{ $table->id }}" value="{{ $i }}"
                                                   @if($table->seats_taken == $i) checked @endif @if($table->status == 'livre') disabled @endif>
                                            <label class="form-check-label" for="modalRadio{{ $table->id }}">
                                                {{ $i }}
                                            </label>
                                        </div>
                                    @endfor

                                    <br>

                                    <table class="table table-hover mt-3">
                                        <thead>
                                        <tr>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Quatidade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($table->status == 'ocupado')
                                            @foreach($products as $product)
                                                <tr>
                                                    <th scope="row">{{ $product->name }}</th>
                                                    <td>R$ {{ $product->price / 100 }}</td>
                                                    <td><input type="number" min="0"
                                                               value="{{ \App\Models\Order::where('table_id', '=', $table->id)->where('product_id', '=', $product->id)->first()->product_quantity }}"
                                                               name="product{{ $product->id }}"></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach($products as $product)
                                                <tr>
                                                    <th scope="row">{{ $product->name }}</th>
                                                    <td>R$ {{ $product->price / 100 }}</td>
                                                    <td>0</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                    @if($table->status != 'livre')
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
@endsection
