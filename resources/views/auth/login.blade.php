@extends('layouts.app')

@section('content')
    <form id="loginForm" class="w-full max-w-md bg-white dark:bg-[#161615] p-8 rounded shadow">
        @csrf
        <h2 class="text-lg font-semibold mb-4">Login</h2>

        <div class="mb-4">
            <label for="email" class="block text-sm mb-1">Email</label>
            <input type="email" name="email" id="email" required class="input">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm mb-1">Password</label>
            <input type="password" name="password" id="password" required class="input">
        </div>

        <button type="submit" class="btn w-full">Login</button>
    </form>
@endsection
@section('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                email: this.email.value,
                password: this.password.value,
            };

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                const data = await response.json();
                const token = data.data.token;
                console.log(data.data.token);

                if (response.ok) {
                    alert(data.message || 'Login successful!');
                    localStorage.setItem('auth_token', token);
                    window.location.href = '/dashboard'; // Redirect as needed
                } else {
                    alert(data.message || 'Login failed!');
                }
            } catch (error) {
                alert('Unexpected error: ' + error.message);
            }
        });
    </script>
@endsection
