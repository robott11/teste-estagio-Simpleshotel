@extends('templates.login-template')
@section('title', 'SimplesHotel - Login')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-5 bg-body border rounded mt-5 p-4">
            <form method="POST">
                @csrf

                <div class="my-2">
                    <h1>Garçom - Login</h1>
                </div>

                @error('status')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                <div class="form-group mb-3">
                    <label for="emailInput">E-mail</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="emailInput"
                           name="email" placeholder="email@exemplo.com" value="{{ old('email') }}" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="passwordInput">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput"
                           name="password" placeholder="********">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Entrar</button>
            </form>
        </div>
    </div>
@endsection
