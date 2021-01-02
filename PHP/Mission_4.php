<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mission_4</title>
</head>

<body>
    <p>Mission_4</p>
    <form action="" method="POST">
        <input type="checkbox" name="create">テーブル作成
        <input type="checkbox" name="show">表示
        <input type="checkbox" name="details">詳細表示
        <input type="checkbox" name="insert">insert
        <input type="checkbox" name="select">select
        <input type="checkbox" name="update">update
        <input type="checkbox" name="delete">delete
        <input type="checkbox" name="drop">drop<br>
        <input type="submit" name="submit"><br>
        <input type="submit" name="quit" value="DB切断">
    </form>

    <?php

    function ok()
    {
        echo "Connection OK!<br>";
    }

    function quit()
    {
        echo "Disconnection!<br>";
    }

    try {
        $db = new PDO("mysql:host=localhost; dbname=(db name); charset=utf8", '(user)', '(password)');
        ok();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST["create"])) {
                $sql = "CREATE TABLE IF NOT EXISTS tbtest (id INT AUTO_INCREMENT PRIMARY KEY,name char(32),comment TEXT);";
                $stmt = $db->query($sql);
            }

            if (!empty($_POST["show"])) {
                $sql = 'SHOW TABLES';
                $result = $db->query($sql);
                foreach ($result as $row) {
                    echo $row[0];
                    echo '<br>';
                }
                echo "<hr>";
            }

            if (!empty($_POST["details"])) {
                $sql = 'SHOW CREATE TABLE tbtest';
                $result = $db->query($sql);
                foreach ($result as $row) {
                    echo $row[1];
                }
                echo "<hr>";
            }

            if (!empty($_POST["insert"])) {
                $sql = $db->prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
                $name = 'hoge';
                $comment = 'hoge'; //好きな名前、好きな言葉は自分で決めること
                $sql->execute();
            }

            if (!empty($_POST["select"])) {
                $sql = 'SELECT * FROM tbtest';
                $stmt = $db->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row) {
                    //$rowの中にはテーブルのカラム名が入る
                    echo $row['id'] . ',';
                    echo $row['name'] . ',';
                    echo $row['comment'] . '<br>';
                    echo "<hr>";
                }
            }

            if (!empty($_POST["update"])) {
                $id = 1; //変更する投稿番号
                $name = "fuga";
                $comment = "fuga"; //変更したい名前、変更したいコメントは自分で決めること
                $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            if (!empty($_POST["delete"])) {
                $id = 2;
                $sql = 'delete from tbtest where id=:id';
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }

            if (!empty($_POST["drop"])) {
                $sql = 'DROP TABLE tbtest';
                $stmt = $db->query($sql);
            }

            if (!empty($_POST["quit"])) {
                $db = null;
                quit();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }

    ?>

</body>

</html>