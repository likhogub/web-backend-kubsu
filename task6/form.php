<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TASK 5</title>
    <style>
        .error {
            border:1px solid red;
        }
        .error1 {
            border:2px solid red;
            font-size:14pt;
            padding: 2px;
            margin: 0 auto 2px;
            width: 420px;
            text-align:center;
        }
        body {
            font:24pt sans-serif;
            text-align:center;
        }
        .complete {
            margin: 0 auto 25px;
            width: 420px;
            border:2px solid green;
            font-size:18pt;
        }
        .complete2 {
            margin: 0 auto 25px;
            width: 420px;
            border:2px solid green;
            font-size:24pt;
        }
        form {
            width: 600px;
            background: white;
            border-radius: 8px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 0 14px 0 rgba(50, 50, 50, 0.75);
            text-align:left;
            font-size:18pt;
        }
        input.submit {
            width: 128px;
            height: 32px;
        }
    </style>
</head>
<body>
<?php
if (!empty($messages)) {
    print('<div id="messages">');
    foreach ($messages as $message) {
        print($message);
    }
    print('</div>');
}
?>
<form action="" method="POST">
    <label>
        Name: <br />
        <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" type="text"/>
    </label><br />
    <label>
        Email:<br />
        <input name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"
               value="sample@example.com"
               type="text" />
    </label><br />
    <label>
        Birth year:<br />
        <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>">
            <option value="выбрать...">Choose...</option>
            <?php for($i = 1900; $i < 2021; $i++) {?>
                <option <?php if ($values['year']==$i){print 'selected="selected"';} ?> value="<?php print $i; ?>"><?= $i; ?></option>
            <?php }?>
        </select>
    </label><br />
    Sex:<br />
    <label><input type="radio"
                  name="sex" <?php if ($values['sex']==0){print 'checked';} ?> value="0" />
        M</label>
    <label><input type="radio" <?php if ($values['sex']==1){print 'checked';} ?>
                  name="sex" value="1" />
        F</label><br />
    Limbs count:<br />
    <label><input type="radio" <?php if ($values['limb']==0 || $values['limb']==1){print 'checked';} ?>
                  name="limb" value="1" />
        1</label>
    <label><input type="radio" <?php if ($values['limb']==2){print 'checked';} ?>
                  name="limb" value="2" />
        2</label>
    <label><input type="radio" <?php if ($values['limb']==3){print 'checked';} ?>
                  name="limb" value="3" />
        3</label>
    <label><input type="radio" <?php if ($values['limb']==4){print 'checked';} ?>
                  name="limb" value="4" />
        4</label>
    <label><br/>
        Superpowers:
        <br />
        <select name="power[]" <?php if ($errors['power']) {print 'class="error"';} ?>
                multiple="multiple">
            <option <?php if (in_array("god",$values['power'])){print 'selected="selected"';} ?> value="god">Immortal</option>
            <option <?php if (in_array("clip",$values['power'])){print 'selected="selected"';} ?> value="clip">Clip</option>
            <option <?php if (in_array("fly",$values['power'])){print 'selected="selected"';} ?> value="fly">Levitation</option>
        </select>
    </label><br />
    <label>
        Biography (optional):<br />
        <textarea class="text" name="bio" placeholder="Your biography" rows=10><?php print $values['bio']; ?></textarea>
    </label><br />
    <label><input type="checkbox"
                  name="check" required />
        Agree with contract</label><br />
    <input type="submit" class="submit" value="Send" />
</form>
</body>
</html>
