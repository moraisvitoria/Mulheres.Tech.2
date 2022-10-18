<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $num = 1;
    while ($num <= 10) {
        $num2 = 0;
        while ($num2 <= 10) {
            $resultado = $num * $num2;
            echo "{$num} x {$num2} = {$resultado}<br>";
            $num2 ++; // $num2 = $num2 + 1;
        }
        echo '<hr>';
        $num ++; // $num = $num + 1;
        if($num == 8) break;
    }
    ?>

</body>

</html>