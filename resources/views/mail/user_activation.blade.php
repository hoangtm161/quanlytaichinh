<!DOCTYPE html>
<html>
<head>
    <title>Activation Email - Allaravel.com</title>
</head>
<body>
<p>
    Hello, {{ $user->name }}, please click below link to activate your account
    </br>
    <a class="btn btn-primary" href="{{ url('/user/activation/'.$user->user_activations->activation_code) }}">Click here to activate your account</a>
</p>
</body>
</html>