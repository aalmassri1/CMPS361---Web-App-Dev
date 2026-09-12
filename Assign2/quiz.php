<!DOCTYPE html>
<html>
    <head>
        <title> Bonus Page </title>
    </head>
    <body>
        <form method="POST">
            <input type="number" name="number">
            <input type="submit" value="Submit">
        <?php
        $number = $_POST["number"];

        if ($number % 2 == 1) {
            echo "The number is odd";
        } else {
            echo "The number is even";
        }
        
        ?>
    </body>
</html>