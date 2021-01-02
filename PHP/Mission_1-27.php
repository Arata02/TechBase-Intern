<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission_1-27</title>
</head>

<body>
    <p>Mission_1-27</p>
    <form action="" method="POST">
        <input type="number" name="num" placeholder="数値を入力">
        <input type="submit" name="submit">
    </form>

    <?php
    $filename = "mission_1-27.txt";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num = $_POST["num"];
        if (file_exists($filename)) {
            $fp = fopen($filename, "a");
            fwrite($fp, "\n");
            fwrite($fp, $num);
        } else {
            $fp = fopen($filename, "w");
            fwrite($fp, $num);
        }
        fclose($fp);
    }

    if (file_exists($filename)) {
        $fp = fopen($filename, "r");
        while (!feof($fp)) {
            $line = fgets($fp);

            if ($line % 3 == 0 && $line % 5 == 0) {
                echo "FizBuzz<br>";
            } elseif ($line % 3 == 0) {
                echo "Fizz<br>";
            } elseif ($line % 5 == 0) {
                echo "Buzz<br>";
            } else {
                echo $line, "<br>";
            }
        }
    }
    fclose($fp)
    ?>
</body>

</html>