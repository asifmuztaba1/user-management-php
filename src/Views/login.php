<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container label,
        .login-container button {
            display: block;
            margin-bottom: 10px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"],
        .login-container button {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s ease;
        }

        .login-container input[type="email"]:focus,
        .login-container input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .login-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #d32f2f;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="/login">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div class="error-message" id="emailError"></div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <div class="error-message" id="passwordError"></div>
        <button type="submit">Login</button>
    </form>
    <div class="login-links">
        <a href="/register">Register</a>
        <span>|</span>
        <a href="/forgot-password">Forgot Password?</a>
    </div>
</div>

<!-- Optional: Include JavaScript for client-side validation -->
<script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var isValid = true;

        // Reset previous error messages
        document.getElementById('emailError').innerHTML = '';
        document.getElementById('passwordError').innerHTML = '';

        // Basic email format validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('emailError').innerHTML = 'Please enter a valid email address.';
            isValid = false;
        }

        // Password length validation
        if (password.length < 6) {
            document.getElementById('passwordError').innerHTML = 'Password must be at least 6 characters long.';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
</body>
</html>
