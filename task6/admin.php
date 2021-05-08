<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form PHP</title>
    <style>
        body {
            font:18pt sans-serif;
            text-align:center;
        }
        table {
            margin: auto;
            border: 1px solid #dddddd;
            border-collapse: collapse;

        }
        table th {
            font-weight: bold;
            padding: 5px;
            background: #efefef;
            border: 1px solid #dddddd;
            border-collapse: collapse;
        }
        .tr1 {
            margin: auto auto 20px;
            border: none;
        }
        .exit {
            margin: 0 auto;
            box-sizing: border-box;
        }
        .exitButton {
            width: 100px;
            height: 30px;
        }
        .selectList {
            font: 16pt sans-serif;
        }
        .editButton {
            width: 100px;
            height: 30px;
        }
    </style>
</head>
<body>
<?php

function sanitize($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pass = false;
    if (!empty($_SERVER['PHP_AUTH_USER']) || !empty($_SERVER['PHP_AUTH_PW'])) {
        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt = $db->prepare("SELECT pwdverify FROM adminpassword WHERE login=:i");
            $result = $stmt->execute(array("i"=> $_SERVER['PHP_AUTH_USER']));
            $hashpwd = (current(current($stmt->fetchAll(PDO::FETCH_ASSOC))));
        }
        catch(PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        if (password_verify($_SERVER['PHP_AUTH_PW'], $hashpwd)) {
            $pass = true;
            session_start();
            $_SESSION['uid']=0;
            $_SESSION['login']=0;
            session_destroy();
            $_SERVER['PHP_ADMIN'] = true;
        }
    }


    if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']) || $pass==false) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Требуется авторизация</h1>');
        exit();
    }

    print('
        <div> 
            <form class="exit" action="" method="POST">
                <input class="exitButton" type="submit" name="exit" value="exit" />
            </form>
        </div>
    ');

    $user = 'task1user';
    $pass = 'task1pass';
    $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try {
        $stmt = $db->prepare("SELECT id,login FROM userpassword");
        $result = $stmt->execute(array("i"=> $_SESSION['login']));
        $idbd = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    catch(PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    $table = '<table border="1">';
    $table .= '<thead> <tr class="tr1">';
    $table .= '<th> Login </th>';
    $table .= '<th> Name </th>';
    $table .= '<th> Email </th>';
    $table .= '<th> Year </th>';
    $table .= '<th> Gender </th>';
    $table .= '<th> Limbs </th>';
    $table .= '<th> Bio </th>';
    $table .= '<th> God </th>';
    $table .= '<th> Clip </th>';
    $table .= '<th> Fly </th>';
    $table .= '</tr> </thead>';


    print('<h3>Список всех пользователей</h3>');
    for ($i=0;$i<count($idbd);$i++) {
        $table .= '<tr class="tr1">';
        try {
            $stmt = $db->prepare("SELECT * FROM userbase WHERE id=:i");
            $result = $stmt->execute(array("i" => $idbd[$i]["id"]));
            $data = current($stmt->fetchAll(PDO::FETCH_ASSOC));
            $stmt1 = $db->prepare("SELECT * FROM usersuperpower WHERE id=:i");
            $result = $stmt1->execute(array("i" => $idbd[$i]["id"]));
            $sp = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            $powers = [];
            $q = 0;
            for ($ii = 0; $ii < count($sp); $ii++) {
                $powers[$q] = $sp[$ii]["power"];
                $q++;
            }
        }
        catch(PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        $table .= '<td>'. sanitize($idbd[$i]['login']) .'</td>';
        $table .= '<td>'. sanitize($data['name']) .'</td>';
        $table .= '<td>'. sanitize($data['email']) .'</td>';
        $table .= '<td>'. sanitize($data['year']) .'</td>';
        $table .= '<td>'. (sanitize($data['sex']) ? 'Ж' : 'М') .'</td>';
        $table .= '<td>'. sanitize($data['limb']) .'</td>';
        $table .= '<td>'. sanitize($data['bio']) .'</td>';
        $table .= '<td>'. (in_array('0',$powers) ? '+' : '-') .'</td>';
        $table .= '<td>'. (in_array('1',$powers) ? '+' : '-') .'</td>';
        $table .= '<td>'. (in_array('2',$powers) ? '+' : '-') .'</td>';
        $table .= '</tr>';
        ?>
    <?php }
    $table .= '</table>';
    print($table);
    ?>
    <h3>Отредактировать данные пользователя</h3>
    <form action="" method="POST">
        <select class = "selectList" name="list" required size = "<?php print(count($idbd)) ?>" >
            <?php for ($i=0;$i<count($idbd);$i++) {
                printf("<option value='%s' >id: %s, login: %s</option>",
                $idbd[$i]["id"], sanitize($idbd[$i]["id"]), sanitize($idbd[$i]["login"]));
            }?>
        </select>
        <div>
            <input class = "editButton" type="submit" name="edit" value="edit" />
            <input class = "editButton" type="submit" name="delete" value="delete" />
        </div>
    </form>
    <h3>Статистика</h3>
    <?php
    $table1 = '<table border="1">';
    $table1 .= '<thead> <tr class="tr1">';
    $table1 .= '<th> God </th>';
    $table1 .= '<th> Clip </th>';
    $table1 .= '<th> Fly </th>';
    $table1 .= '</tr> </thead>';
    $table1 .= '<tr class="tr1">';
    for ($i=0;$i<3;$i++) {
        try {
            $stmt = $db->prepare("SELECT id FROM usersuperpower WHERE power=:i");
            $result = $stmt->execute(array("i" => $i));
            $datap = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        $table1 .= '<td>'. count($datap) .'</td>';
    }
    $table1 .= '</tr>';
    $table1 .= '</table>';
    print($table1);
}
else {
    if( isset( $_POST['exit'] ) ) {
        session_start();
        $_SESSION['uid']=0;
        $_SESSION['login']=0;
        session_destroy();
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        exit();
    }
    if( isset( $_POST['delete'] ) )
    {
        print_r($_POST['list']);
        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt1 = $db->prepare("DELETE FROM userpassword where id=:id");
            $stmt1 -> bindParam(':id', $_POST['list']);
            $stmt1 -> execute();
            $stmt2 = $db->prepare("DELETE FROM usersuperpower where id=:id");
            $stmt2 -> bindParam(':id', $_POST['list']);
            $stmt2 -> execute();
            $stmt3 = $db->prepare("DELETE FROM userbase where id=:id");
            $stmt3 -> bindParam(':id', $_POST['list']);
            $stmt3 -> execute();
        } catch(PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        print_r(" Запись удалена");
    }
    if ( isset( $_POST['edit'] ) ){
        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt1 = $db->prepare("SELECT login FROM userpassword WHERE id=:i");
            $result = $stmt1->execute(array("i"=> $_POST['list']));
            $login = (current(current($stmt1->fetchAll(PDO::FETCH_ASSOC))));
        }
        catch(PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        session_start();
        $_SESSION['uid'] = substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
        $_SESSION['login'] = $login;
        header('Location: ./');
        exit();
    }
} ?>
</body>
</html>
