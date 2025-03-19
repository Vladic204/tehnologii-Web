<?php
session_start(); // Start the session

// Redirect authenticated users
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: welcome.php");
    exit;
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Define the JSON file path
        $jsonFile = 'users.json';

        // Check if the JSON file exists
        if (!file_exists($jsonFile)) {
            $error = "Baza de date a utilizatorilor nu există.";
        } else {
            // Read the JSON file
            $jsonData = file_get_contents($jsonFile);
            $users = json_decode($jsonData, true); // Decode JSON to an associative array

            if (!is_array($users)) {
                $error = "Eroare la citirea datelor utilizatorilor.";
            } else {
                // Search for the user by username
                $userFound = false;
                $userIndex = -1;
                foreach ($users as $index => $user) {
                    if ($user['username'] === $username) {
                        $userFound = true;
                        $userIndex = $index;
                        // Verify password
                        if (password_verify($password, $user['password'])) {
                            // Generate a new token
                            $token = bin2hex(random_bytes(16)); // 32-character hexadecimal token

                            // Update the user with the new token
                            $users[$userIndex]['token'] = $token;

                            // Save the updated users array back to the JSON file
                            $jsonData = json_encode($users, JSON_PRETTY_PRINT);
                            if (file_put_contents($jsonFile, $jsonData) === false) {
                                $error = "Eroare la salvarea tokenului.";
                            } else {
                                // Set session variables
                                $_SESSION['loggedin'] = true;
                                $_SESSION['username'] = $user['username'];
                                $_SESSION['user_id'] = $userIndex; // Using array index as a pseudo-ID

                                // Redirect to index.html with the token
                                header("Location: index.html?token=" . urlencode($token));
                                exit;
                            }
                        } else {
                            $error = "Nume utilizator sau parolă incorecte";
                        }
                        break;
                    }
                }

                if (!$userFound) {
                    $error = "Nume utilizator sau parolă incorecte";
                }
            }
        }
    } else {
        $error = "Completați ambele câmpuri";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('images/image1.jpg'); /* Relative path to the image */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
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
            width: 100%;
            padding: 0.8rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #ff0000;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Autentificare</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Nume utilizator" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Parolă" required>
            </div>
            <button type="submit">Loghează-te</button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>