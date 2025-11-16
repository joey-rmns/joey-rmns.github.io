<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $BASE_URL = $_SERVER['HTTP_HOST'] . '/your_site/';
} else if ($_SERVER['SERVER_NAME'] === 'osiris.ubishops.ca') {
    $BASE_URL = $_SERVER['HTTP_HOST'] . '/username/'; 
} else {
    $BASE_URL = $_SERVER['HTTP_HOST'] . '/';
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $password_hash = hash('sha256', $password);
    
    if ($password_hash === 'b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff') {

        header('Location: http://' . $BASE_URL . 'to-do.php');
        exit();
    } else {
        $error = 'Incorrect password. Please try again.';
    }
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
            <p>Please enter the password to access the to-do list.</p>

            <form method="post" action="login.php">
                <div class="form-row">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Submit</button>

                <?php if ($error): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>