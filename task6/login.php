<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

if( isset( $_POST['sessiondestroy'] ) )
{
    session_destroy();
    header('Location: ./');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_SESSION['login'])) {
        print(
        '<form method="POST" action="login.php">
            <input type="submit" name="sessiondestroy" value="Выход" />
        </form>'
        );
    } else {
        print(
        '<form action="login.php" method="post">
            <input name="login" />
            <input name="pwd" />
            <input type="submit" value="Войти" />
        </form>'
        );
    }
}
else {
    $user = 'task1user';
    $pass = 'task1pass';
    $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try {
        $stmt = $db->prepare("SELECT pwd FROM userpassword WHERE login=:i");
        $result = $stmt->execute(array("i"=>$_POST['login']));
        $hashedpassword = (current(current($stmt->fetchAll(PDO::FETCH_ASSOC))));
    }
    catch(PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    if (empty($hashedpassword)){
        print ("Нет пользователя");
    }
    else {
        if (password_verify($_POST['pwd'], $hashedpassword)) {
            $_SESSION['uid'] = '12';
            $_SESSION['login'] = $_POST['login'];
            header('Location: ./');
            exit();
        } else {
            print( 'Wrong password.');
        }
    }
    exit();
}
