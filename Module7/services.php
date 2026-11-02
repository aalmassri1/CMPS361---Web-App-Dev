<?php
session_start();                            // CHECKS WHETHER USER HAS LOGGED IN?

if (!isset($_SESSION['username'])) {        // CHECK SAVED USERNAME
    header('Location: index.php');          
    exit;                                   // IF FAILED, THESE LINED ARE RAN
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Study Planner</title>
</head>
<body>
    <h1>
        Welcome, <?= htmlspecialchars(              // DISPLAYS USERNAME AS TEXT
            $_SESSION['username'],                  // GETS USERNAME SAVED DURING LOGIN
            ENT_QUOTES,                             // HANDLES ALL QUOTES
            'UTF-8'                                 // TELLS PHP HOW TO READ THE CODE
        ) ?>!
    </h1>

    <p>You are logged into your Student Study Planner.</p>

    <h2>Study Checklist</h2>
    <ul>
        <li>Review class notes.</li>
        <li>Complete homework assignments.</li>
        <li>Prepare for the next exam.</li>
    </ul>

    <form action="logout.php" method="post">
        <button type="submit">Log Out</button>
    </form>
</body>
</html>