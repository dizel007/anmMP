<?php

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
// нулевая позиция первого элемента    
$array_position = array(
        'x' => 0,
        'y' => 0,
        'z' => 0
    );

$some_size_box = array(
        'height' => 0.2,
        'length' => 0.2,
        'width' => 0.2
    );


$array_cargo  = Array ( 'calculated_size' => $some_size_box,
    'cargo_id' => 1212,
    'id' => 19,
    'mass'  => 1,
    'position' => $array_position,
    'size' => $some_size_box,
    'sort' => 1,
    'stacking' => true,
    'turnover' => true,
    'type' => "box"
    );



 /// КАНТА СТАНДАРТ ГОРИЗОНТАЛЬНО   
$kanta_standart_gorizont = array(
        'height' => 0.145,
        'length' => 0.56,
        'width' => 0.56
    );
/// КАНТА СТАНДАРТ ВЕРТИКАЛЬНО
$kanta_standart_vertical = array(
        'height' => 0.56,
        'length' => 0.56,
        'width' => 0.145
    );
/// КАНТА СТАНДАРТ ВЕРТИКАЛЬНО_90
$kanta_standart_vertical_90 = array(
    'height' => 0.56,
    'length' => 0.145,
    'width' => 0.56
);

//////////////  MINI **********************************
$kanta_mini_gorizont = array(
        'height' => 0.11,
        'length' => 0.5,
        'width' => 0.5
    );
$kanta_mini_vertical = array(
        'height' => 0.5,
        'length' => 0.5,
        'width' => 0.11
    );

$kanta_mini_vertical_90 = array(
        'height' => 0.495,
        'length' => 0.11,
        'width' => 0.495);

///  1840 - 8910 *********************************************************
$anker_8910_1840_gorizont = array(
    'height' => 0.11,
    'length' => 0.285,
    'width' => 0.11
);
$anker_8910_1840_gorizont_90 = array(
    'height' => 0.11,
    'length' => 0.11,
    'width' => 0.285
);

// 1940-10

$anker_1940_gorizont = array(
    'height' => 0.03,
    'length' => 0.26,
    'width' => 0.045
);

$anker_1940_gorizont_90 = array(
    'height' => 0.03,
    'length' => 0.045,
    'width' => 0.26
);


///  метровый бордюр *********************************************************
$bord_metrovi_gorizont = array(
    'height' => 0.17,
    'length' => 1.02,
    'width' => 0.22
);

$bord_metrovi_virtical = array(
    'height' => 1.02,
    'length' => 0.17,
    'width' => 0.22
);


///  1840 - 8910 *********************************************************
$kokos_gorizont= array(
    'height' => 0.15,
    'length' => 1.02,
    'width' => 0.16
);
