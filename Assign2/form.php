<!DOCTYPE html>
<html>
    <head>
        <title> Form Page </title>
    </head>
    <body>
        <form method="POST">
            <label> Name: </label>
            <input type="text" name="name">
            <br><br>
            <label> Age: </label>
            <input type="text" name="age">
            <br><br>
            <input type="submit" value="Submit">
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $name = $_POST["name"];
                $age = $_POST["age"];

                echo "Hello, $name! You are $age years old.";

            }
        ?>
    </body>
</html>