<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar-se no Twitter / Twitter</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <header class="container">
        <div class="logo">
            <img src="{{ URL('images/img/twitter-logo.png') }}" alt="Logo do Twitter" style="width: 25%">
        </div>
    </header>

    <main class="container">
        <h1>Registrar-se no Twitter</h1>
        <div class="form-container">
            <form method="post" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="inputs">
                    <label for="nome">Nome completo</label><br>
                    <input type="text" id="nome" name="name" autocomplete="name" required>
                </div>
                <div class="inputs">
                    <label for="email">E-mail</label><br>
                    <input type="email" id="email" name="email" autocomplete="email" required>
                </div>
                <div class="inputs">
                    <label for="senha">Password</label><br>
                    <input type="password" id="senha" name="password" autocomplete="new-password" required>
                </div>
                <div class="inputs">
                    <label for="birthday">Data de nascimento</label><br>
                    <input type="date" id="birthday" name="birthday" required>

                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" v-model="gender" id="dot-1" value="male">
                    <input type="radio" name="gender" v-model="gender" id="dot-2" value="female">
                    <input type="radio" name="gender" v-model="gender" id="dot-3" value ="null">
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                </div>
                <br>
                <button class="button" type="submit" name="register">Registrar-se</button>
            </form>
            <div class="links">
                <a href="{{ route('loginindex') }}" target="">Have Account? Entrar</a>
                <a href="{{ route('welcome') }}">Welcome Twitter</a>

            </div>
        </div>
    </main>
</body>

</html>
