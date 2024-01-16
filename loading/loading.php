<?php
function loading_image(){
echo <<<HTML
<link rel="stylesheet" href="../loading/loading.css" type="text/css"/>

<div class="loading_img">
    <img class="loading_img" src="../loading/load.gif" alt="альтернативный текст"  height="500" >  
    Please wait................
</div>
HTML;
};
