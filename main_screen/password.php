<?php

echo <<<HTML
<h2>Пасврод</h2>
<div>
    <form method="get" action="#">
    <input  required type="text" name="pasword_suka" value="">
    <input type="submit" value="Вводи пароль">
    </form>
</div>

HTML;
if (isset ($_GET['pasword_suka'])){
if ($_GET['pasword_suka'] <> '1122@') {
    die('Пароль неверен');
}
} else {
    die('Net passa');
}