<?php

$file = file_get_contents('test.json');


$data = json_decode($file, true);
// echo "<pre>";
// print_r($data);

// Размеры паллеты
$arr_cargo_space = Array
(
    'loading_size' => Array
        (
            'height' => 2,
            'length' => 1.2,
            'width' => 0.8
        ),

    'position' => Array
        (
            0 => 0.6,
            1 => 1.0,
            2 => 0.4
        ),

    'type' => "pallet"
    );

// размеры канты
$height_kantri_standart = 0.22;
$length_kantri_standart = 1.0;
$width_kantri_standart = 0.17;

$kanta_standart_gorizont = array(
        'height' => $height_kantri_standart,
        'length' => $length_kantri_standart,
        'width' => $width_kantri_standart
    );
$kanta_standart_vertical = array(
        'height' => $width_kantri_standart,
        'length' => $length_kantri_standart,
        'width' => $height_kantri_standart
    );

$array_position = array(
    'x' => $length_kantri_standart/2,
    'y' => 0.13,
    'z' => $width_kantri_standart/2,
);
$array_cargo  = Array ( 'calculated_size' => $kanta_standart_gorizont,
                        'cargo_id' => 1212,
                        'id' => 19,
                        'mass'  => 1,
                        'position' => $array_position,
                        'size' => $kanta_standart_gorizont,
                        'sort' => 1,
                        'stacking' => 1,
                        'turnover' => 90,
                        'type' => "box"
                        );







$paletta=array();
$j=0.11;
for ($i=1; $i<=9; $i++) {
  
        $array_cargo['position']['x'] = 0.5;
        $array_cargo['position']['y'] = $j;
        add_cargo_in_paletta($paletta,$array_cargo);
        $j=$j+0.22;

}

$j=0.11;
for ($i=1; $i<=9; $i++) {
  
    $array_cargo['position']['x'] = 0.5;
    $array_cargo['position']['y'] = $j;
    $array_cargo['position']['z'] = 0.25;
      
    add_cargo_in_paletta($paletta,$array_cargo);
    $j=$j+0.22;

}

$j=0.11;
$array_cargo['position']['z'] = $array_cargo['position']['z'] + $width_kantri_standart;
for ($i=1; $i<=9; $i++) {
  
    $array_cargo['position']['x'] = 0.5;
    $array_cargo['position']['y'] = $j;
    add_cargo_in_paletta($paletta,$array_cargo);
    $j=$j+0.22;

}

$j=0.11;
$array_cargo['position']['z'] = $array_cargo['position']['z'] + $width_kantri_standart;
for ($i=1; $i<=9; $i++) {
  
    $array_cargo['position']['x'] = 0.5;
    $array_cargo['position']['y'] = $j;
    add_cargo_in_paletta($paletta,$array_cargo);
    $j=$j+0.22;

}





/// вертикальные канты
// $array_position = array(
//     'x' => 0.3,
//     'y' => 0.3,
//     'z' => 0.67,
// );

// $array_cargo['position'] = $array_position;
// $array_cargo['calculated_size'] = $kanta_standart_vertical ;
// $array_cargo['size'] = $kanta_standart_vertical ;


// $j =0.3;
// for ($i=1; $i<=6; $i++) {
//     if ((($i % 2) == 0) && ($i>1))  {
//         $array_cargo['position']['x'] = 0.3;
//         $array_cargo['position']['y'] = $j;
//         add_cargo_in_paletta($paletta,$array_cargo);
    
//         $j=$j+0.6;
       
//     } else {
//         $array_cargo['position']['x'] = 0.9;
           
//     $array_cargo['position']['y'] = $j;
//     add_cargo_in_paletta($paletta,$array_cargo);
 
//     }

// }


$new_cargo['cargoSpace'] = $arr_cargo_space;
$new_cargo['cargos'] = $paletta;

echo "<pre>";
print_r($new_cargo);

$file = file_put_contents('test_ner.json' , json_encode($new_cargo));

die();

/// функция по добавлению товара на паллету
function add_cargo_in_paletta(&$paletta , $arr_product) {
    $paletta[]= $arr_product; 
}

// функция установки установки товара в массив 
function add_tovar_v_massiv ($tovar) {
    $array_cargo  = Array ( 'calculated_size' => $tovar,
    'cargo_id' => 1212,
    'id' => 19,
    'mass'  => 1,
    'size' => $tovar,
    'sort' => 1,
    'stacking' => 1,
    'turnover' => 1,
    'type' => "box"
    );
return $array_cargo;
}

// функция установки кантри стандарт горизонтально
function add_kantry_standart_gorizont ($array_position) {
    $kanta_standart_gorizont = array(
        'height' => 0.13,
        'length' => 0.6,
        'width' => 0.6
    );
    $array_cargo = add_tovar_v_massiv ($kanta_standart_gorizont);
    $array_cargo['position'] = $array_position;

}
