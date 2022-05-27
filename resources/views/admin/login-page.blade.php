<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.1.3/dist/sandstone/bootstrap.min.css">

    <title>Admin - Login</title>
</head>
<body class="bg-dark">
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-sm-5 bg-body border rounded mt-4 p-4">
            <form method="POST">
                @csrf

                <div class="my-2">
                    <h1>ADMIN - Login</h1>
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

                <button type="submit" class="btn btn-lg btn-danger">Entrar</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
