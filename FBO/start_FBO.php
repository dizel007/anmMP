<?php

// $file = file_get_contents('test.json');


// $data = json_decode($file, true);
// echo "<pre>";
// print_r($data);
require_once "palette_data.php";


// обновили товар в массиве


$paletta=array();


//***************  Кантри стандарт первый столбец  **************************************************/
add_tovar_v_massiv ($array_cargo, $kanta_standart_gorizont);
$array_cargo['cargo_id'] = "kantri_ST";
 $x = $array_cargo['calculated_size']['length']/2;
 $y = $array_cargo['calculated_size']['height'];
 $z = $array_cargo['calculated_size']['width']/2;
$j = $y/2;
$x_sdvig = $array_cargo['calculated_size']['length'];
for ($k=1; $k<=2; $k++) { // количество столбцов
    $x_sdvig = 0.0 + $array_cargo['calculated_size']['length'] * ($k-1); // смещение по оси Х
        for ($i=1; $i<=14; $i++) { // количество рядов
                $array_cargo['position']['x'] = $x + $x_sdvig;
                $array_cargo['position']['y'] = $j;
                $array_cargo['position']['z'] = $z;
                add_cargo_in_paletta($paletta,$array_cargo); // добавляем товар на паллету
                $j = $j + $y; // увеличиваем координату по оси Y
        }
$j = $y/2; // смещение по оси Y
}



//***************  борд метровый первый столбец  **************************************************/
add_tovar_v_massiv ($array_cargo, $bord_metrovi_gorizont);
$array_cargo['cargo_id'] = "kantri_ST";
 $x = $array_cargo['calculated_size']['length']/2;
 $y = $array_cargo['calculated_size']['height'];
 $z = $array_cargo['calculated_size']['width']/2;
 $x_sdvig =0;
$j = $y/2;
$z_sdvig = 0.56;
for ($k=1; $k<=1; $k++) { // количество столбцов
    // $z_sdvig = 0.0 + $z * 2 * ($k-1); // смещение по оси Х
        for ($i=1; $i<=11; $i++) { // количество рядов
                $array_cargo['position']['x'] = $x + $x_sdvig;
                $array_cargo['position']['y'] = $j;
                $array_cargo['position']['z'] = $z + $z_sdvig;
                add_cargo_in_paletta($paletta,$array_cargo); // добавляем товар на паллету
                $j = $j + $y; // увеличиваем координату по оси Y
        }
$j = $y/2; // смещение по оси Y
}

//***************  борд метровый первый столбец  **************************************************/
add_tovar_v_massiv ($array_cargo, $bord_metrovi_virtical);
$array_cargo['cargo_id'] = "kantri_ST";
 $x = $array_cargo['calculated_size']['length']/2;
 $y = $array_cargo['calculated_size']['height'];
 $z = $array_cargo['calculated_size']['width']/2;
 $x_sdvig =1.02;
$j = $y/2;
$z_sdvig = 0.56;
for ($k=1; $k<=1; $k++) { // количество столбцов
    // $z_sdvig = 0.0 + $z * 2 * ($k-1); // смещение по оси Х
        for ($i=1; $i<=2; $i++) { // количество рядов
                $array_cargo['position']['x'] = $x + $x_sdvig;
                $array_cargo['position']['y'] = $j;
                $array_cargo['position']['z'] = $z + $z_sdvig;
                add_cargo_in_paletta($paletta,$array_cargo); // добавляем товар на паллету
                $j = $j + $y; // увеличиваем координату по оси Y
        }
$j = $y/2; // смещение по оси Y
}





/****************************************************************************************
***************************************************************************************
****************************************************************************************/








$new_cargo['cargoSpace'] = $arr_cargo_space;
$new_cargo['cargos'] = $paletta;
echo "<pre>";
print_r($new_cargo);
$file = file_put_contents('test_new.json' , json_encode($new_cargo));


die();

/// функция по добавлению товара на паллету
function add_cargo_in_paletta(&$paletta , $arr_product) {
    $paletta[]= $arr_product; 
}

// функция установки установки товара в массив 
function add_tovar_v_massiv (&$array_cargo, $tovar) {
    $array_cargo  = Array ( 'calculated_size' => $tovar,
    'cargo_id' => 1212,
    'id' => 1,
    'mass'  => 1,
    'size' => $tovar,
    'sort' => 1,
    'stacking' => false,
    'turnover' => false,
    'type' => "box"
    );
return $array_cargo;
}

