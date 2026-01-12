<form method="POST" action="/candidate/login">
    @csrf
    <h3>Login Kandidat</h3>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Mulai Tes</button>
</form>
