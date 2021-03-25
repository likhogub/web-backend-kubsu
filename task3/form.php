<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>TASK 3</title>
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
	</style>
</head>
<body>
<form action="" method="POST">
    <label>
      Имя:<br />
      <input name="fio"/>
    </label><br />
    <label>
      Email:<br />
      <input name="email"
        value="sample@example.com"
        type="email" />
    </label><br />
    <label>
      Год рождения:<br />
    <select name="year">
      <?php for ($i = 1900; $i < 2021;$i++) {
        print('<option type="value" value="');
        print($i);
        print('">');
        print($i);
        print('</option>');}?>
    </select>
    </label><br />
    Пол:<br />
    <label><input type="radio" checked="checked"
      name="sex" value="M" />
      М</label>
    <label><input type="radio"
      name="sex" value="Ж" />
      Ж</label><br />
    Количество конечностей:<br />
    <label><input type="radio" checked="checked"
      name="limb" value="1" />
      1</label>
    <label><input type="radio"
      name="limb" value="2" />
      2</label><br />
      <label><input type="radio"
      name="limb" value="3" />
      3</label><br />
      <label><input type="radio"
      name="limb" value="4" />
      4</label><br />
    <label>
        Способности:
        <br />
        <select name="power[]"
          multiple="multiple">
          <option value="ab_god">Бессмертие</option>
          <option value="ab_clip">Прохождение сквозь стены</option>
          <option value="ab_fly">Левитация</option>
        </select>
    </label><br />
    <label>
      Биография:<br />
      <textarea name="bio"></textarea>
    </label><br />
    <label><input type="checkbox"
      name="check" required/>
      С контрактом ознакомлен</label><br />
    <input type="submit" value="Отправить" />
</form>
</body>
</html>
