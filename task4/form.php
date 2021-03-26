<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>TASK 4</title>
    <style>
	   form {
	       width: 600px;
	       height: 700px;
	       background: white;
	       border-radius: 8px;
	       margin: 0 auto;
	       padding: 30px;
	       box-shadow: 0px 0px 14px 0px rgba(50, 50, 50, 0.75);
	   }
	   p {
	       line-height: 0.5;
	   }
	   label {
	       margin: 3px;
	   }
	   input {
	       margin: 8px 0;
	   }
	   input[type="text"], input[type="email"] {
	       width: 100%;
	       height: 30px;
	       border-radius: 5px;
	       border: 2px solid grey;
	       outliine: none;
	       padding: 7px;
	   }
	   input[type="checkbox"] {
	       margin-right: 7px;
	   }
	   textarea {
	       width: 300px;
	       height: 150px;
	       padding: 7px;
	   }
	   input[type="submit"] {
	       padding: 7px 20px;
	       border-radius: 5px;
	       box-shadow: 0px 0px 5px 0px rgba(46, 53, 55, 0.5);
	   }
	   input[type="submit"]:hover {
	       cursor: pointer;
	   }
           .error {
               border: 1px red solid !important;
           }
	</style>
</head>
<body>
<form action="" method="POST">
    <label>
      Имя:<br />
      <input name="fio" <?php if ($errors['fio']) print('class="error"');?>  value="<?php print($NAME);?>"  />
    </label><br />
    <label>
      Email:<br />
      <input name="email" <?php if ($errors['email']) print('class="error"');?> 
        value="<?php print($EMAIL);?>"
        type="email" />
    </label><br />
    <label>
      Год рождения:<br />
    <select name="year" >
      <?php for ($i = 1900; $i < 2021;$i++) {
        print('<option value="');
        print($i);
        if ($YEAR == $i) print('" selected="selected">');
	else print('">');
        print($i);
        print('</option>');}?>
    </select>
    </label><br />
    Пол:<br />
    <label><input type="radio" <?php if ($SEX == "М") print("checked"); ?>
      name="sex" value="М" />
      М</label>
    <label><input type="radio" <?php if ($SEX == "Ж") print("checked");  ?> 
      name="sex" value="Ж" />
      Ж</label><br />
    Количество конечностей:<br />
<?php for ($i = 1; $i <= 4; $i++) {
    print('<label><input type="radio" name="limb"');
    if ($LIMB == $i) print('checked="checked" value="');
    else print('value="'); 
    print($i);
    print('"/>');
    print($i);
    print('</label>');
}
?>
<br />
    <label>
        Способности:
        <br />
        <select name="power[]"
          multiple="multiple">
          <option value="ab_god" <?php if ($GOD) print('selected');  ?> >Бессмертие</option>
          <option value="ab_clip" <?php if ($CLIP) print('selected');  ?> >Прохождение сквозь стены</option>
          <option value="ab_fly" <?php if ($FLY) print('selected');  ?>>Левитация</option>
        </select>
    </label><br />
    <label>
      Биография:<br />
      <textarea name="bio"><?php print($BIO);?> </textarea>
    </label><br />
    <label><input type="checkbox"
      name="check" required/>
      С контрактом ознакомлен</label><br />
    <input type="submit" value="Отправить" />
</form>
</body>
</html>
