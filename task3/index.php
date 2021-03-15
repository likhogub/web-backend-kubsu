<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  print("hi");
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

print_r($_POST);
print_r($_POST["power"]);
?>
