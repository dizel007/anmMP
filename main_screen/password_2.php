<?php
if (!isset ($_GET['pasword_anm'])){
    
echo <<<HTML
        <h2>Введите пароль</h2>
        <div>
            <form method="get" action="#">
            <input  required type="text" name="pasword_anm" value="">
            <input type="submit" value="Вводи пароль">
            </form>
        </div>
HTML;
die('XXX');
  
 }

sleep(4);

if (isset ($_GET['pasword_anm'])){
if ($_GET['pasword_anm'] <> '123123@') {
    die('Пароль неверен');
}
} else {
    die('Нет пароля');
}


