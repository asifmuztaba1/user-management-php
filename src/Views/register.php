<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-container label,
        .register-container button {
            display: block;
            margin-bottom: 10px;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container button {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s ease;
        }

        .register-container input[type="text"]:focus,
        .register-container input[type="email"]:focus,
        .register-container input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .register-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .register-container button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #d32f2f;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Register</h2>
    <form id="registerForm" method="POST" action="/register">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div class="error-message" id="emailError"></div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="password_confirmation" required>
        <div class="error-message" id="passwordError"></div>
        <button type="submit">Register</button>
    </form>
    <div class="login-links">
        <a href="/login">Login</a>
        <span>|</span>
        <a href="/forgot-password">Forgot Password?</a>
    </div>
</div>

<!-- Optional: Include JavaScript for client-side validation -->
<script>
    document.getElementById('registerForm').addEventListener('submit', function (event) {
        var username = document.getElementById('username').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var confirmPassword = document.getElementById('confirmPassword').value.trim();
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

        // Password match validation
        if (password !== confirmPassword) {
            document.getElementById('passwordError').innerHTML = 'Passwords do not match.';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
</body>
</html>
