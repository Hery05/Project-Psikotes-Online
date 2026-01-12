<!DOCTYPE html>
<html>
<head>
    <title>Login Psikotes</title>
    <link rel="stylesheet" href="/adminlte/css/adminlte.min.css">
</head>
<body class="login-page">

<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login Psikotes</p>

            @if(session('error'))
                <p class="text-danger">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login">
                @csrf
                <input type="email" name="email"
                       class="form-control mb-3"
                       placeholder="Email" required>

                <input type="password" name="password"
                       class="form-control mb-3"
                       placeholder="Password" required>

                <button class="btn btn-primary btn-block">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
</body>
    <br>
    <div class="login-footer">
        <strong>Copyright &copy; 2025 <a href="#">Hery Ardiansyah</a>.</strong>
    </div>
</html>
