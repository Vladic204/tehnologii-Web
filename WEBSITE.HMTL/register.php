<?php
session_start(); // Start the session for potential future use

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Use password_hash for security

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresa de email nu este validă.";
        exit;
    }

    // Define the JSON file path
    $jsonFile = 'users.json';

    // Initialize an empty array for users
    $users = [];

    // Check if the JSON file exists and load existing data
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $users = json_decode($jsonData, true); // Decode JSON to an associative array
        if (!is_array($users)) {
            $users = []; // If JSON is invalid, start with an empty array
        }
    }

    // Check if the username or email already exists
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "Numele de utilizator este deja folosit.";
            exit;
        }
        if ($user['email'] === $email) {
            echo "Adresa de email este deja folosită.";
            exit;
        }
    }

    // Generate a secure token
    $token = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal token

    // Create a new user array with the token
    $newUser = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'token' => $token
    ];

    // Add the new user to the users array
    $users[] = $newUser;

    // Encode the array to JSON and save it to the file
    $jsonData = json_encode($users, JSON_PRETTY_PRINT);
    if (file_put_contents($jsonFile, $jsonData) === false) {
        echo "Eroare la salvarea datelor.";
        exit;
    }

    // Redirect to index.html with the token as a query parameter
    header("Location: index.html?token=" . urlencode($token));
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/image1.jpg'); /* Relative path to the image */
            background-size: cover; /* Ensures the image covers the entire background */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents tiling */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent white for readability */
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

        button {
            width: 100%; /* Ensures full width */
            padding: 0.8rem;
            background-color: #4CAF50; /* Consistent green color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            display: block; /* Ensures proper block-level rendering */
            margin: 0 auto; /* Centers the button if needed */
        }

        button:hover {
            background-color: #45a049; /* Slightly darker green on hover */
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Înregistrare Automobile</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Nume utilizator" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Parolă" required>
            </div>
            <button type="submit">Înregistrează-te</button>
        </form>
    </div>
</body>
</html>