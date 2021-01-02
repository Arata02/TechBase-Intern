<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission_3-5</title>
</head>

<body>
    <p>Mission_3-5</p>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="名前を入力">
        <input type="text" name="txt" placeholder="コメントを入力">
        <input type="password" name="pass" placeholder="パスワード">
        <input type="submit" name="submit"><br>
        <input type="number" name="num">
        <input type="submit" name="delete" value="削除">
        <input type="submit" name="edit" value="編集">
    </form>

    <?php

    $filename = "mission_3.txt";

    $array = file($filename, FILE_IGNORE_NEW_LINES);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $txt = $_POST["txt"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["pass"];
        $num = 0;

        if (isset($_POST["submit"])) {
            if (file_exists($filename)) {
                $maxNum = 0;
                for ($i = 0; $i < count($array); $i++) {
                    $ex = explode("<>", $array[$i]);
                    $num = intval($ex[0]);
                    if ($num > $maxNum) {
                        $maxNum = $num;
                    }
                }
                $num = $maxNum + 1;

                $fp = fopen($filename, "a");
                $text = $num . "<>" . $name . "<>" . $txt . "<>" . $date . "<>" . $pass . "<>";
                fwrite($fp, $text);
                fwrite($fp, "\n");
            } else {
                $num = 1;
                $fp = fopen($filename, "w");
                $text = $num . "<>" . $name . "<>" . $txt . "<>" . $date . "<>" . $pass . "<>";
                fwrite($fp, $text);
                fwrite($fp, "\n");
            }
            fclose($fp);
        }

        if (isset($_POST["delete"])) {
            $pass = $_POST["pass"];
            $delete = $_POST["num"];
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            $fp = fopen($filename, "w");
            for ($i = 0; $i < count($lines); $i++) {
                $delData = explode("<>", $lines[$i]);
                if (!($delData[0] == $delete && $delData[4] == $pass)) {
                    fwrite($fp, $lines[$i]);
                    fwrite($fp, "\n");
                }
            }
            fclose($fp);
        }

        if (isset($_POST["edit"])) {
            $pass = $_POST["pass"];
            $edit = $_POST["num"];
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            $fp = fopen($filename, "w");
            for ($i = 0; $i < count($lines); $i++) {
                $data = explode("<>", $lines[$i]);
                if ($data[0] != $edit) {
                    fwrite($fp, $lines[$i]);
                    fwrite($fp, "\n");
                } else if ($data[0] == $edit && $data[4] == $pass) {
                    $text = $edit . "<>" . $name . "<>" . $txt . "<>" . $date . "<>" . $pass . "<>";
                    fwrite($fp, $text);
                    fwrite($fp, "\n");
                }
            }
        }
        fclose($fp);
    }

    $array = file($filename, FILE_IGNORE_NEW_LINES);
    for ($i = 0; $i < count($array); $i++) {
        $ex = explode("<>", $array[$i]);
        echo $ex[0] . "\t" . $ex[1] . "\t" . $ex[2] . "\t" . $ex[3] . "<br>";
    }

    ?>

</body>

</html>