<?php
session_start(); // Start the session

// Set the content type to JSON
header('Content-Type: application/json');

// Handle logout
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
    echo json_encode(['success' => true, 'redirect' => 'login.php']);
    exit;
}

// Redirect authenticated users
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo json_encode(['success' => true, 'redirect' => 'welcome.php']);
    exit;
}

$response = ['success' => false, 'error' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $jsonFile = 'users.json';
        if (!file_exists($jsonFile)) {
            $response['error'] = "Baza de date a utilizatorilor nu există.";
        } else {
            $jsonData = file_get_contents($jsonFile);
            $users = json_decode($jsonData, true);

            if (!is_array($users)) {
                $response['error'] = "Eroare la citirea datelor utilizatorilor.";
            } else {
                $userFound = false;
                $userIndex = -1;
                foreach ($users as $index => $user) {
                    if ($user['username'] === $username) {
                        $userFound = true;
                        $userIndex = $index;
                        if (password_verify($password, $user['password'])) {
                            $token = bin2hex(random_bytes(16));
                            $users[$userIndex]['token'] = $token;
                            $jsonData = json_encode($users, JSON_PRETTY_PRINT);
                            if (file_put_contents($jsonFile, $jsonData) === false) {
                                $response['error'] = "Eroare la salvarea tokenului.";
                            } else {
                                $_SESSION['loggedin'] = true;
                                $_SESSION['username'] = $user['username'];
                                $_SESSION['user_id'] = $userIndex;
                                $response['success'] = true;
                                $response['redirect'] = "index.php";
                            }
                        } else {
                            $response['error'] = "Nume utilizator sau parolă incorecte";
                        }
                        break;
                    }
                }
                if (!$userFound) {
                    $response['error'] = "Nume utilizator sau parolă incorecte";
                }
            }
        }
    } else {
        $response['error'] = "Completați ambele câmpuri";
    }
}

// Output the JSON response and exit
echo json_encode($response);
exit;