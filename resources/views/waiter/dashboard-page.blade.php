@extends('templates.dashboard-template')
@section('title', 'SimplesHotel - Dashboard')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul>
                @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                            @if($table->status != 'livre')
                                Editar
                            @else
                                Agendar
                            @endif
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
                                                   @if($table->seats_taken == $i) checked @endif>
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
                                                    <td><input type="number" min="0" value="0"
                                                               name="product{{ $product->id }}"></td>
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
                                    @if($table->status == 'ocupado')
                                        <a href="{{ url('/dashboard/fechar', [$table->id]) }}" class="btn btn-success">Fechar Conta</a>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        @if($table->status != 'livre')
                                            Atualizar
                                        @else
                                            Reservar
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <script>
        // Prevent empty number input fields
        const numInputs = document.querySelectorAll('input[type=number]')

        numInputs.forEach(function (input) {
            input.addEventListener('change', function (e) {
                if (e.target.value == '') {
                    e.target.value = 0
                }
            })
        })
    </script>
@endsection
