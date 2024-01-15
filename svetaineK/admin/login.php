<!DOCTYPE html>  
<html lang="en">  
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        .login-container {
            margin: auto;
            width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input_field {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .submit_button button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .submit_button button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        
        <form action="../src/login_handler.php" method="post">
            <div class="input_field">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input_field">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="submit_button">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
