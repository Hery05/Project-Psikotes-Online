<form method="POST" action="/hrd/login">
    @csrf
    <h3>Login HRD</h3>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>
