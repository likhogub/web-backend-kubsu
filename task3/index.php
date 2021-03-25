<?php
header('Content-Type: text/html; charset=UTF-8');
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Заполните email.<br/>');
  $errors = TRUE;
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  print('Email введен некорректно.<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

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
header('Location: ?save=1');
?>
