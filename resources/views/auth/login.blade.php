<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="text" name="name" placeholder="User">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>