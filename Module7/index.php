<?php
session_start();
require 'db.php';   // PHP starts a session and then connects to the database

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    //Check whether the form was submitted 
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';       // Reads what the user typed

    $result = pg_query_params(      // PHP searches for that username
        $conn,
        'SELECT username, password FROM users WHERE username = $1',     // $1 is just a placeholder
        [$username]
    );

    if ($result === false) {
        $error = 'Unable to log in right now.';
    } elseif (pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);        // PHP retrieves the account and checks password

        if (hash_equals(
            $user['password'],
            crypt($password, $user['password']) // Hashes the password
        )) {
            session_regenerate_id(true);
            $_SESSION['username'] = $user['username']; // Correct password = logs user in

            header('Location: services.php');
            exit;                               // Leads to welcome page
        } else {
            $error = 'Invalid username or password.';   // Incorrect Login
        }
    } else {
        $error = 'Invalid username or password.';       // Incorrect Login
    }

    pg_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Planner Login</title>
</head>
<body>
    <h1>Student Study Planner</h1>
    <p>Log in to access your study planner.</p>

    <?php
        if ($error !== '') {
        echo '<p>Invalid username or password.</p>';
        }
    ?> // ERROR MESSAGE

    <form action="index.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>
        <br><br>

        <button type="submit">Log In</button>
    </form>
</body>
</html>