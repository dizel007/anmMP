<?php

$Zakaz_v_1c = 12312;
/******************************************************************************************
 *  ************   Создаем каталог для сегодняшнего разбора
 ******************************************************************************************/
$new_date = date('Y-m-d');
make_new_dir_z('reports/'.$new_date,0); // создаем папку с датой
$new_path = 'reports/'.$new_date."/".$Zakaz_v_1c;
echo $new_path."<br>";
make_new_dir_z($new_path,0); // создаем папку с номером заказа
$path_qr_supply = $new_path.'/qr_code_supply';
make_new_dir_z($path_qr_supply.'/qr_code_supply',0); // создаем папку с QR

$path_stikers_orders = $new_path.'/stikers_orders';
make_new_dir_z($path_stikers_orders,0); // создаем папку со стикерами

$path_arhives = $new_path.'/arhives';
make_new_dir_z($path_arhives,0); // создаем папку с архивами

 function make_new_dir_z($dir, $append) {

    if (!is_dir($dir)) {
        mkdir($dir, 0777, True);
    } 

}
