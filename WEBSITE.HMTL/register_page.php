<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/image1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .nav-button, .logout-button {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin: 0.5rem;
            background: linear-gradient(45deg, #4CAF50, #66BB6A);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .nav-button:hover, .logout-button:hover {
            background: linear-gradient(45deg, #45a049, #5cb860);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .nav-button:active, .logout-button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            color: #ff0000;
            margin-top: 1rem;
            text-align: center;
        }

        .button-group {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Înregistrare Utilizator</h2>
        <form id="registerForm">
            <div class="form-group">
                <input type="text" name="username" placeholder="Nume utilizator" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Parolă" required>
            </div>
            <div class="button-group">
                <button type="submit" class="nav-button">Înregistrare</button>
                <a href="login_page.php" class="nav-button">Logare</a>
            </div>
        </form>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <div class="button-group">
                <a href="register_handler.php?logout=true" class="logout-button">Deconectare</a>
            </div>
        <?php endif; ?>
        <div class="error-message" id="errorMessage"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Get form data
                var formData = $(this).serialize();

                // Clear previous error messages
                $('#errorMessage').text('');

                // Make AJAX request
                $.ajax({
                    url: 'register.php', // The backend file to handle the registration
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Redirect to the welcome page if registration is successful
                            window.location.href = response.redirect;
                        } else {
                            // Display error message
                            $('#errorMessage').text(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log the response for debugging
                        console.log('Error Response:', xhr.responseText);
                        console.log('Status:', status);
                        console.log('Error:', error);
                        // Display a user-friendly error message
                        $('#errorMessage').text('Eroare la procesarea cererii. Verificați consola pentru detalii.');
                    }
                });
            });
        });
    </script>
</body>
</html>