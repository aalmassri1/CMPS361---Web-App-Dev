<!DOCTYPE html>
<html>
    <head>
        <title> Grades Page </title>
    </head>
    <body>
        <?php
        $grade = 65;
        if ($grade >= 90) {
            echo "A";
        } elseif ($grade >= 80) {
            echo "B";
        } elseif ($grade >= 70) {
            echo "C";
        } else {
            echo "F";
        }
        ?>
        <p> Your grade is <?php echo $grade ?> </p>
    </body>
</html>