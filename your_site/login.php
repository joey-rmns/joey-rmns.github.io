<?php

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    
    $BASE_URL = 'localhost/your_site/';
} else if ($_SERVER['SERVER_NAME'] === 'osiris.ubishops.ca') {
    $BASE_URL = 'osiris.ubishops.ca/home/jroumanos/';
} else {
    $BASE_URL = $_SERVER['HTTP_HOST'] . '/';
}

require_once __DIR__ . '/includes/config.php';
start_custom_session();

$error = '';
$success_message = '';
$username = '';

if (!empty($_COOKIE['todo-username'])) {
    $username = $_COOKIE['todo-username'];
}

$attemptsFile = __DIR__ . '/login_attempts.json';
$serverName = $_SERVER['SERVER_NAME'] ?? '';
$isLocal = in_array($serverName, ['localhost', '127.0.0.1']);
$attempts = [];

if ($isLocal && file_exists($attemptsFile) && is_readable($attemptsFile)) {
    $json = file_get_contents($attemptsFile);
    $decoded = json_decode($json, true);
    if (is_array($decoded)) {
        $attempts = $decoded;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'login';

    if ($action === 'logout') {
        session_destroy();
        start_custom_session(); // Start fresh session
        $success_message = 'Successfully logged out.';
        $username = ''; 
    }
    else if ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Username and password are required.';
        } else {
            if (!isset($attempts[$username])) {
                $attempts[$username] = [
                    'attempts'     => 0,
                    'locked_until' => 0,
                ];
            }

            if ($attempts[$username]['locked_until'] > time()) {
                $remaining = $attempts[$username]['locked_until'] - time();
                $error = "Too many wrong attempts. Please wait {$remaining} seconds before trying again.";
            } else {
                $password_hash = hash('sha256', $password);

                $correct_hash = 'b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff';

                if ($password_hash !== $correct_hash) {
                    $attempts[$username]['attempts'] += 1;

                    if ($attempts[$username]['attempts'] >= 3) {
                        $attempts[$username]['locked_until'] = time() + 30;
                        $attempts[$username]['attempts'] = 0;
                        $error = 'You entered the wrong password 3 times. You are locked out for 30 seconds.';
                    } else {
                        $error = 'Incorrect password. Please try again.';
                    }
                } else {
                    $attempts[$username]['attempts'] = 0;
                    $attempts[$username]['locked_until'] = 0;

                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['username'] = $username;

                    setcookie('todo-username', $username, time() + (60 * 60 * 24 * 30), '/');

                    header('Location: http://' . $BASE_URL . 'to-do.php');
                    exit();
                }
            }
        }

        if ($isLocal && is_writable(dirname($attemptsFile))) {
            file_put_contents($attemptsFile, json_encode($attempts));
        }
    }
}

if (!empty($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: http://' . $BASE_URL . 'to-do.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To-Do List</title>
    <link rel="stylesheet" href="my_style.css">
    <script src="js/nav.js" defer></script>
    <style>
    .error-message {
        color: red;
        margin-top: 10px;
        font-weight: bold;
    }
    .success-message {
        color: green;
        margin-top: 10px;
        font-weight: bold;
    }
    .login-container {
        max-width: 500px;
        margin: 60px auto;
        padding: 40px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .form-row {
        margin-bottom: 20px;
    }
    .form-row label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    .form-row input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .btn {
        background: #3498DB;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn:hover {
        background: #2980B9;
    }
    </style>
</head>
<body>
    <header>
        <?php require_once 'nav.php'; ?>
    </header>

    <main class="container">
        <div class="login-container">
            <h1>Access To-Do List</h1>
            <p>Please enter your username and the password to access the to-do list.</p>

            <form method="post" action="login.php">
                <div class="form-row">
                    <label for="username">Username:</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?php echo htmlspecialchars($username); ?>"
                        required
                    >
                </div>

                <div class="form-row">
                    <label for="password">Password:</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <input type="hidden" name="action" value="login">

                <button type="submit" class="btn">Submit</button>

                <?php if ($error): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
                <?php endif; ?>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>