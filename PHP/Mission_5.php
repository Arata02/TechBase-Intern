<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission_5</title>
</head>

<body>
    <p>Mission_5</p>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="名前を入力">
        <input type="text" name="txt" placeholder="コメントを入力">
        <input type="password" name="pass" placeholder="パスワード">
        <input type="submit" name="submit" value="登録"><br>
        <input type="number" name="id">
        <input type="submit" name="delete" value="削除">
        <input type="submit" name="edit" value="編集">
    </form>

    <?php

    try {
        $db = new PDO("mysql:host=localhost; dbname=(db name); charset=utf8", '(user)', '(password)');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $sql = "CREATE TABLE IF NOT EXISTS post (id INT AUTO_INCREMENT PRIMARY KEY, name char(32), comment TEXT, dt DATETIME, pass TEXT);";
            $stmt = $db->query($sql);

            $name = $_POST["name"];
            $comment = $_POST["txt"];
            $dt = date("Y/m/d H:i:s");
            $pass = $_POST["pass"];

            if (!empty($_POST["submit"])) {
                $sql = $db->prepare("INSERT INTO post (name, comment, dt, pass) VALUES (:name, :comment, :dt, :pass)");
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql->bindParam(':dt', $dt, PDO::PARAM_STR);
                $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
                $sql->execute();
            }

            if (!empty($_POST["edit"])) {
                $id = $_POST["id"];
                $pass = $_POST["pass"];
                $sql = 'UPDATE post SET name=:name,comment=:comment WHERE id=:id AND pass=:pass';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->execute();
            }

            if (!empty($_POST["delete"])) {
                $id = $_POST["id"];
                $pass = $_POST["pass"];
                $sql = 'delete from post where id=:id AND pass=:pass';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                $stmt->execute();
            }

            $sql = 'SELECT * FROM post';
            $stmt = $db->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row) {
                echo $row['id'] . ' ';
                echo $row['name'] . ' ';
                echo $row['comment'] . ' ';
                echo $row['dt'] . '<br>';
                echo $row['pass'] . ' ';
                echo "<hr>";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }

    ?>

</body>

</html>