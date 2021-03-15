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
      Дата рождения:<br />
      <input name="field-date" type="date" value="2020-09-07"/>
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
          <option value="god">Бессмертие</option>
          <option value="clip">Прохождение сквозь стены</option>
          <option value="fly">Левитация</option>
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
