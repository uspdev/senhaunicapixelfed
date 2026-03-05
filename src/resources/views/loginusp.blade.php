<!DOCTYPE html>
<html>
<head>
    <title>Login USP</title>
</head>
<body>
    <p>Bem vindo ao Pixelfed da USP!</p>
    <form action="/store" method="POST">
        @csrf
        <p>Insira seu e-mail USP</p>
        <input type="text" name="email">
        <button type="submit">Login</button>
    </form>
</body>
</html>
