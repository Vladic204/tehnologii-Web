<?php
session_start(); // Start the session

// Set the content type to JSON
header('Content-Type: application/json');

// Handle logout
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    echo json_encode(['success' => true, 'redirect' => 'register.php']);
    exit;
}

$response = ['success' => false, 'error' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = "Adresa de email nu este validă.";
    } else {
        $jsonFile = 'users.json';
        $users = [];

        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $users = json_decode($jsonData, true);
            if (!is_array($users)) {
                $users = [];
            }
        }

        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $response['error'] = "Numele de utilizator este deja folosit.";
                echo json_encode($response);
                exit;
            }
            if ($user['email'] === $email) {
                $response['error'] = "Adresa de email este deja folosită.";
                echo json_encode($response);
                exit;
            }
        }

        $token = bin2hex(random_bytes(16));
        $newUser = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'token' => $token
        ];

        $users[] = $newUser;
        $jsonData = json_encode($users, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFile, $jsonData) === false) {
            $response['error'] = "Eroare la salvarea datelor.";
        } else {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $response['success'] = true;
            $response['redirect'] = "index.php;
        }
    }
}

// Output the JSON response and exit
echo json_encode($response);
exit;