<!DOCTYPE html>
<html>
    <head>
        <title> Calculator Page </title>
    </head>
    <body>
        <?php
        $num1 = 10;
        $num2 = 5;
        $sum = $num1 + $num2;
        $difference = $num1 - $num2;
        $product = $num1 * $num2;
        $quotient = $num1/$num2;
        ?>
        <p>The sum of <?php echo $num1 ?> and <?php echo $num2 ?> is <?php echo $sum ?></p>
        <p>The difference of <?php echo $num1 ?> and <?php echo $num2 ?> is <?php echo $difference ?></p>
        <p>The product of <?php echo $num1 ?> and <?php echo $num2 ?> is <?php echo $product ?></p>
        <p>The quotient of <?php echo $num1 ?> and <?php echo $num2 ?> is <?php echo $quotient ?></p>   
    </body>
</html>