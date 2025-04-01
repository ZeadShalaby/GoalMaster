<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar no Twitter / Twitter</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

</head>

<body>

    <header class="container">
        <div class="logo">
            <img src="{{ URL('images/img/twitter-logo.png') }}" alt="Logo do Twitter" style="width: 40%">
        </div>
    </header>

    <main class="container">
        <h1>Entrar no Twitter</h1>
        <div class="container">
            <form method="post" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="inputs">
                    <label class="usuario" for="usuario">Celular, e-mail ou username</label><br>
                    <input type="text" id="usuario" name="field" value="{{ old('field') }}">
                </div>
                <div class="inputs">
                    <label class="senha" for="senha">password</label><br>
                    <input type="password" id="senha" name="password" value="{{ old('password') }}">
                </div>
                <br>
                <button class="button" name="login" type="submit">Entrar</button>
            </form>
            <div class="links container">
                <a target="" href="{{ route('registerIndex') }}">Haven`t Account? </a>
                <span class="ponto"></span>
                <a href="{{ route('welcome') }}">Welcome Twitter</a>
            </div>
        </div>
    </main>
</body>

</html>
