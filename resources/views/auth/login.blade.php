<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #d4f1b8;
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="relative w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Background Image -->
        <div class="relative w-full h-full">
            <img src="{{ asset('images/BGLogin.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 opacity-100"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row">
            <img alt="Illustration" class="absolute inset-0 w-full h-full object-cover z-0" src="{{ asset('images/FormLogin.png') }}" />
            <!-- Form Section -->
            <div class="relative w-full md:w-1/2 p-8 bg-white rounded-lg shadow-lg md:ml-4 md:mr-4 md:mt-5 md:mb-5">
                <div class="flex flex-col items-center">
                    <!-- Logo -->
                    <img alt="Logo" class="mb-4" height="100" src="{{ asset('images/Logo.png') }}" width="200"/>
                    <h1 class="text-2xl font-bold mb-2">SELAMAT DATANG</h1>
                    <!-- Login Form -->
                    <form class="w-full" method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <div class="mb-4">
                            <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                name="email" placeholder="Email" type="text" required/>
                        </div>
                        <div class="mb-4 relative">
                            <input id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                name="password" placeholder="Password" type="password" required/>
                            <i id="eye-icon" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500"
                                onclick="togglePasswordVisibility()"></i>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <a class="text-sm text-blue-500" href="#">Lupa Kata Sandi</a>
                        </div>
                        <button class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" type="submit">Masuk</button>
                    </form>
                    <p class="mt-4 text-sm">
                        Belum memiliki akun?
                        <a class="text-blue-500" href="{{ route('manage.user') }}">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk toggle visibility password -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
