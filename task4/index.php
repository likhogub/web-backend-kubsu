<?php
header('Content-Type: text/html; charset=UTF-8');
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '0', 1);
    print('Спасибо, результаты сохранены.');
  }
  
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    $_COOKIE['fio'] = "";
    print('<div class="error">Заполните имя.</div>');
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $_COOKIE['email'] = "";
    print('<div class="error">Заполните e-mail.</div>');
  }

  $NAME = empty($_COOKIE['fio']) ? '' : $_COOKIE['fio'];
  $EMAIL = empty($_COOKIE['email']) ? '' : $_COOKIE['email'];
  $SEX = empty($_COOKIE['sex']) ? '' : $_COOKIE['sex'];
  $YEAR = empty($_COOKIE['year']) ? '' : $_COOKIE['year'];
  $LIMB = empty($_COOKIE['limb']) ? '' : $_COOKIE['limb'];
  $BIO = empty($_COOKIE['bio']) ? '' : $_COOKIE['bio'];
  $GOD = empty($_COOKIE['god']) ? '' : $_COOKIE['god'];
  $CLIP = empty($_COOKIE['clip']) ? '' : $_COOKIE['clip'];
  $FLY = empty($_COOKIE['fly']) ? '' : $_COOKIE['fly'];
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  setcookie('fio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else {
  setcookie('fio', $_POST['fio'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['email'])) {
  setcookie('email_error', '1', time() + 30 * 24 * 60 * 60);
  $errors = TRUE;

} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  setcookie('email_error', '1', time() + 30 * 24 * 60 * 60);
  $errors = TRUE;
} else {
  setcookie('email', $_POST['email'], time() + 30 * 24 * 60 * 60);
}

if ($errors) {
  header('Location: index.php');
  exit();
} else {
  setcookie('fio_error', '', 100000);
  setcookie('email_error', '', 100000);
  setcookie('limb', $_POST['limb'], 0);
  setcookie('sex', $_POST['sex'], 0);
  setcookie('year', $_POST['year'], 0);
  setcookie('god', intval(in_array("ab_god", $_POST['power'])), 0);
  setcookie('fly', intval(in_array("ab_fly", $_POST['power'])), 0);
  setcookie('clip', intval(in_array("ab_clip", $_POST['power'])), 0);
}

setcookie('save', '1', 0);
header('Location: index.php');

$user = 'task1user';
$pass = 'task1pass';
$db = new PDO('mysql:host=localhost;dbname=study', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
try {
    $stmt = $db->prepare("INSERT INTO users (name, year, sex, email, bio, limb, ab_god, ab_clip, ab_fly) VALUES (:name, :year, :sex, :email, :bio, :limb, :god, :clip, :fly)");
    $stmt->bindParam(':name', $_POST['fio']);
    $stmt->bindParam(':year', $_POST['year']);
    $stmt->bindParam(':sex', $_POST['sex']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':bio', $_POST['bio']);
    $stmt->bindParam(':limb', intval($_POST['limb']));
    $stmt->bindParam(':god', intval(in_array("ab_god", $_POST['power'])));
    $stmt->bindParam(':clip', intval(in_array("ab_clip", $_POST['power'])));
    $stmt->bindParam(':fly', intval(in_array("ab_fly", $_POST['power'])));
    $stmt->execute();
} catch(PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}
?>
