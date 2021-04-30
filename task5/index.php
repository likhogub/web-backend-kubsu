<?php
header('Content-Type: text/html; charset=UTF-8');
$ability_data = ['god', 'clip', 'fly'];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
        $messages[] = '<div class="complete">Data saved</div>';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf(
                '<div class = "complete2">
                            <a href="login.php">Sign-in</a> <br/>username <strong>%s</strong> <br/>pass <strong>%s</strong></div>',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['year'] = !empty($_COOKIE['year_error']);
    $errors['power'] = !empty($_COOKIE['power_error']);
    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        $messages[] = '<div class="error1">Fill name</div>';
    }
    if ($errors['email']) {
        if ($errors['email'] == 1) {
            setcookie('email_error', '', 100000);
            $messages[] = '<div class="error1">Fill valid email</div>';
        } else {
            setcookie('email_error', '', 100000);
            $messages[] = '<div class="error1">Fill valid email</div>';
        }
    }
    if ($errors['year']) {
        setcookie('year_error', '', 100000);
        $messages[] = '<div class="error1">Choose valid year</div>';
    }
    if ($errors['power']) {
        setcookie('power_error', '', 100000);
        $messages[] = '<div class="error1">Choose superpower</div>';
    }
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
    $values['power'] = empty($_COOKIE['power_value']) ? '' : unserialize($_COOKIE['power_value']);
    $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
    $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];

    if (!isset($_SESSION)) {
        session_start();
    }

    if ($errors &&
        !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])
    ) {
        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt = $db->prepare("SELECT id FROM userpassword WHERE login=:i");
            $result = $stmt->execute(array("i" => $_SESSION['login']));
            $idbd = (current(current($stmt->fetchAll(PDO::FETCH_ASSOC))));
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        try {
            $stmt = $db->prepare("SELECT * FROM userbase WHERE id=:i");
            $result = $stmt->execute(array("i" => $idbd));
            $data = current($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        $values['name'] = filter_var($data['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['email'] = filter_var($data['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['year'] = filter_var($data['year'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['sex'] = $data['sex'];
        $values['limb'] = $data['limb'];
        $values['bio'] = filter_var($data['bio'], FILTER_SANITIZE_SPECIAL_CHARS);
        $abil = [];
        foreach ($data['power'] as $a) {
            $q = 0;
            if (in_array($a, $data['power'])) {
                $abil[$q] = $ability_data[$a];
                $q++;
            }
        }
        $values['power'] = $abil;
        printf('<div class="complete2"> Logged as %s</div>', $_SESSION['login']);
    }
    include('login.php');
    include('form.php');
} else {
    $errors = FALSE;

    if (empty($_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = true;
    } else {
        setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '2', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['year'])) {
        setcookie('year_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $year = $_POST['year'];
        if (!(is_numeric($year) && intval($year) >= 1900 && intval($year) < 2020)) {
            setcookie('year_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
        }
    }

    if (empty($_POST['power'])) {
        setcookie('power_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $abilities = $_POST['power'];
        foreach ($abilities as $ability) {
            if (!in_array($ability, $ability_data)) {
                print('Invalid superpower<br>');
                $errors = TRUE;
            }
        }
    }
    if ($errors == false) {
        setcookie('power_value', serialize($_POST['power']), time() + 30 * 24 * 60 * 60);
        setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
        setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60);
        setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
    }

    $ability_insert = [];
    foreach ($ability_data as $ability) {
        $ability_insert[$ability] = in_array($ability, $abilities) ? 1 : 0;
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('name_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('power_error', '', 100000);
    }
    if (!isset($_SESSION)) {
        session_start();
    }
    $messages[] = '<div class="complete">SAS</div>';
    printf($_COOKIE[session_name()]);
    printf($_SESSION['login']);
    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt = $db->prepare("SELECT id FROM userpassword WHERE login=:i");
            $result = $stmt->execute(array("i" => $_SESSION['login']));
            $idbd = (current(current($stmt->fetchAll(PDO::FETCH_ASSOC))));
            $stmt1 = $db->prepare("UPDATE userbase SET name=:name, year=:year, sex=:sex, email=:email, bio=:bio, limb=:limb WHERE id =:id");
            $stmt1->bindParam(':name', $_POST['name']);
            $stmt1->bindParam(':year', $_POST['year']);
            $stmt1->bindParam(':sex', $_POST['sex']);
            $stmt1->bindParam(':email', $_POST['email']);
            $stmt1->bindParam(':bio', $_POST['bio']);
            $stmt1->bindParam(':limb', $_POST['limb']);
            $stmt1->bindParam(':id', $idbd);
            $stmt1->execute();
            $stmt0 = $db->prepare("SELECT power FROM usersuperpower WHERE id=:i");
            $result = $stmt0->execute(array("i" => $idbd));
            $powerstemp = $stmt0->fetchAll(PDO::FETCH_ASSOC);
            $powers = [];
            $q = 0;
            foreach ($powerstemp as $element) {
                $powers[$q] = $element[power];
                $q++;
            }
            if (!empty($ability_insert['god']) && !in_array('0', $powers)) {
                $stmt2 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt2->bindParam(':id', $idbd);
                $stmt2->bindParam(':power', intval(0));
                $stmt2->execute();
            } else if (empty($ability_insert['god']) && in_array('0', $powers)) {
                $stmt3 = $db->prepare("DELETE FROM usersuperpower where id=:id and power=:power");
                $stmt3->bindParam(':id', $idbd);
                $stmt3->bindParam(':power', intval(0));
                $stmt3->execute();
            }
            if (!empty($ability_insert['clip']) && !in_array('1', $powers)) {
                $stmt4 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt4->bindParam(':id', $idbd);
                $stmt4->bindParam(':power', intval(1));
                $stmt4->execute();
            } else if (empty($ability_insert['clip']) && in_array('1', $powers)) {
                $stmt5 = $db->prepare("DELETE FROM usersuperpower where id=:id and power=:power");
                $stmt5->bindParam(':id', $idbd);
                $stmt5->bindParam(':power', intval(1));
                $stmt5->execute();
            }
            if (!empty($ability_insert['fly']) && !in_array('2', $powers)) {
                $stmt6 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt6->bindParam(':id', $idbd);
                $stmt6->bindParam(':power', intval(2));
                $stmt6->execute();
            } else if (empty($ability_insert['fly']) && in_array('2', $powers)) {
                $stmt7 = $db->prepare("DELETE FROM usersuperpower where id=:id and power=:power");
                $stmt7->bindParam(':id', $idbd);
                $stmt7->bindParam(':power', intval(2));
                $stmt7->execute();
            }
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    } else {
        $login = uniqid("user");
        $pwd = uniqid("pass");
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $pwd);

        $user = 'task1user';
        $pass = 'task1pass';
        $db = new PDO('mysql:host=localhost;dbname=study4', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        try {
            $stmt = $db->prepare("INSERT INTO userbase (name,year,sex,email,bio,limb) VALUES (:name,:year,:sex,:email,:bio,:limb)");
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':year', $_POST['year']);
            $stmt->bindParam(':sex', $_POST['sex']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':bio', $_POST['bio']);
            $stmt->bindParam(':limb', $_POST['limb']);
            $stmt->execute();
            $last_id = $db->lastInsertId();
            if (!empty($ability_insert['god'])) {
                $stmt1 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt1->bindParam(':id', intval($last_id));
                $stmt1->bindParam(':power', intval(0));
                $stmt1->execute();
            }
            if (!empty($ability_insert['clip'])) {
                $stmt2 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt2->bindParam(':id', intval($last_id));
                $stmt2->bindParam(':power', intval(1));
                $stmt2->execute();
            }
            if (!empty($ability_insert['fly'])) {
                $stmt3 = $db->prepare("INSERT INTO usersuperpower (id, power) VALUES (:id,:power)");
                $stmt3->bindParam(':id', intval($last_id));
                $stmt3->bindParam(':power', intval(2));
                $stmt3->execute();
            }
            $stmt4 = $db->prepare("INSERT INTO userpassword (id, login, pwd) VALUES (:id,:login, :pwd)");
            $stmt4->bindParam(':id', intval($last_id));
            $stmt4->bindParam(':login', $login);
            $stmt4->bindParam(':pwd', password_hash($pwd, PASSWORD_DEFAULT));
            $stmt4->execute();
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    setcookie('save', '1');

    header('Location: index.php');
}
