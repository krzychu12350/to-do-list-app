@extends('layouts.app')

@section('content')
    <form id="registerForm" class="w-full max-w-md bg-white dark:bg-[#161615] p-8 rounded shadow">
        @csrf
        <h2 class="text-lg font-semibold mb-4">Register</h2>

        <div class="mb-4">
            <label for="name" class="block text-sm mb-1">Name</label>
            <input type="text" name="name" id="name" required class="input">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm mb-1">Email</label>
            <input type="email" name="email" id="email" required class="input">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm mb-1">Password</label>
            <input type="password" name="password" id="password" required class="input">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="input">
        </div>

        <button type="submit" class="btn w-full">Register</button>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('registerForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = {
                name: this.name.value,
                email: this.email.value,
                password: this.password.value,
                password_confirmation: this.password_confirmation.value,
            };
            try {
                const response = await fetch('/api/auth/register', {
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
                    alert(data.message || 'Registration successful!');
                    localStorage.setItem('auth_token', token);
                    window.location.href = '/dashboard';
                } else {
                    alert(data.message || 'Registration failed!');
                }
            } catch (error) {
                alert('Unexpected error: ' + error.message);
            }
        });
    </script>
@endsection
