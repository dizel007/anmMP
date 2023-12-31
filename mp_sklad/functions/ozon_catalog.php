<?php
function get_catalog_ozon () {
$arr_catalog = array(
// метровый комплекты с якорями
    array('article' =>'7245-К-10-30', 'OzonProductID' =>'718694111' , 'sku' =>'1282704105', 'barcode' => 'OZN1282704105', 'name' => '7245-К-10-30 Экобордюр КОНТУР Б-100.05.08 пластиковый черный L-1000 мм, H-45 мм, (УПАКОВКА 10 шт. плюс 30 якорей)' ),
    array('article' =>'7260-К-8-24',  'OzonProductID' =>'718761682' , 'sku' =>'1282759434', 'barcode' => 'OZN1282759434', 'name' => '7260-К-8-24 Экобордюр КОНТУР Б-100.06.08 пластиковый черный L-1000 мм, H-60 мм, (УПАКОВКА 8 шт. плюс 24 якоря)' ),
    array('article' =>'7280-К-6-18',  'OzonProductID' =>'718765125' , 'sku' =>'1282760677', 'barcode' => 'OZN1282760677', 'name' => '7280-К-6-18 Экобордюр КОНТУР Б-100.08.08 пластиковый черный L-1000 мм, H-80 мм, (УПАКОВКА 6 шт. плюс 18 якорей)' ),
// метровый комплекты БЕЗ якорей
    array('article' =>'7245-К-10', 'OzonProductID' =>'718804156' , 'sku' =>'1282804426', 'barcode' => 'OZN1282704105', 'name' => '7245-К-10 Экобордюр КОНТУР Б-100.05.08 пластиковый черный L-1000 мм, H-45 мм, (УПАКОВКА 10 шт.)' ),
    array('article' =>'7260-К-8',  'OzonProductID' =>'718808591' , 'sku' =>'1282808793', 'barcode' => 'OZN1282808793', 'name' => '7260-К-8 Экобордюр КОНТУР Б-100.06.08 пластиковый черный L-1000 мм, H-60 мм, (УПАКОВКА 8 шт.)' ),
    array('article' =>'7280-К-6',  'OzonProductID' =>'719799118' , 'sku' =>'1283708573', 'barcode' => 'OZN1283708573', 'name' => '7280-К-6 Экобордюр КОНТУР Б-100.08.08 пластиковый черный L-1000 мм, H-80 мм, (УПАКОВКА 6 шт.)' ),

// метровый СТАРЫЕ комплекты 
    array('article' =>'7245-К-16', 'OzonProductID' =>'246532300' , 'sku' =>'522674167', 'barcode' => 'OZN522674166', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 45 мм, 16 штук' ),
    array('article' =>'7260-К-12', 'OzonProductID' =>'246533379' , 'sku' =>'522675673' , 'barcode' => 'OZN522675674', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 60 мм, 12 штук, арт. 7260-К-12' ),
    array('article' =>'7280-К-8', 'OzonProductID' =>'246534375' , 'sku' =>'522678569' , 'barcode' => 'OZN522678568', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 80 мм, 8 штук, арт. 7280-К-8' ),
    
    array('article' =>'7280', 'OzonProductID' =>'336594806' , 'sku' =>'664665914' , 'barcode' => 'OZN664665913', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 80 мм, 1 штука, арт. 7280-К-1' ),
    array('article' =>'7260', 'OzonProductID' =>'336604105' , 'sku' =>'664697071' , 'barcode' => 'OZN664697072', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 60 мм, 1 штука, арт. 7260-К-1' ),
    array('article' =>'7245', 'OzonProductID' =>'336618823' , 'sku' =>'664720473' , 'barcode' => 'OZN664720472', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 45 мм, 1 штука, арт. 7245-К-1' ),
    
    array('article' =>'1940-10', 'OzonProductID' =>'56869659' , 'sku' =>'233924855' , 'barcode' => 'OZN233924852', 'name' => 'Крепящий якорь к бордюру ANMAKS Кантри. Оцинкованная сталь. 10 штук, арт. 1940-10' ),
    array('article' =>'1840-30', 'OzonProductID' =>'246108361' , 'sku' =>'521884852' , 'barcode' => 'OZN521884851', 'name' => 'Крепящий якорь ANMAKS универсальный. Пластик. 30 штук, арт. 1840-30' ),
    array('article' =>'8910-30', 'OzonProductID' =>'246816740' , 'sku' =>'523170684' , 'barcode' => 'OZN523170685', 'name' => 'Крепящий анкер универсальный ANMAKS пластиковый, 30 штук, арт. 8910-30' ),
 
    array('article' =>'ANM.39*59', 'OzonProductID' =>'244184619' , 'sku' =>'518682944' , 'barcode' => 'OZN518682943', 'name' => 'Решетка придверная грязезащитная стальная ANMAKS, 39 х 59 cм' ),
    array('article' =>'ANM.49*99', 'OzonProductID' =>'232157194' , 'sku' =>'500199266' , 'barcode' => 'OZN500199267', 'name' => 'Решетка придверная грязезащитная стальная ANMAKS, 49 х 99 cм' ),
    
    array('article' =>'508АК', 'OzonProductID' =>'236917988' , 'sku' =>'507383556' , 'barcode' => 'OZN507383557', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая оцинкованная под крепеж, 1000х136 мм' ),
    array('article' =>'503А', 'OzonProductID' =>'237377794' , 'sku' =>'508149302' , 'barcode' => 'OZN508149303', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая из нержавеющей стали, 1000х136 мм' ),
    array('article' =>'508А', 'OzonProductID' =>'236935930' , 'sku' =>'508336745' , 'barcode' => 'OZN508336744', 'name' => 'Решетка водоприемная ANMAKS DN100 стальная оцинкованная, 1000х136 мм' ),

    
    array('article' =>'508А-10', 'OzonProductID' =>'237381288' , 'sku' =>'508143277' , 'barcode' => 'OZN508143276', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая стальная оцинкованная, 1000х136 мм. Комплект - 10 штук' ),
    array('article' =>'508АК-10', 'OzonProductID' =>'237528047' , 'sku' =>'508352124' , 'barcode' => 'OZN508352129', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая оцинкованная, 1000х136 мм.  Под крепеж. Комплект - 10 штук' ),
    array('article' =>'503А-10', 'OzonProductID' =>'240822865' , 'sku' =>'513511679' , 'barcode' => 'OZN513511677', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая из нержавеющей стали, 1000х136 мм. Комплект - 10 штук' ),
    
    array('article' =>'7262-КП', 'OzonProductID' =>'520076890' , 'sku' =>'985937305' , 'barcode' => 'OZN985937306', 'name' => 'Садовый приствольный круг ANMAKS КОНТУР-КП-60.06' ),

    array('article' =>'82400-Ч', 'OzonProductID' =>'56476066' , 'sku' =>'233035518' , 'barcode' => 'OZN233035516', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI черный, длина 10000 мм, высота 80 мм, арт. 82400-Ч' ),
    array('article' =>'82401-Ч', 'OzonProductID' =>'56471829' , 'sku' =>'232956901' , 'barcode' => 'OZN232956898', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри черный, длина 10000 мм, высота 110 мм, арт. 82401-Ч' ),
    array('article' =>'82402-Ч', 'OzonProductID' =>'56479147' , 'sku' =>'233024314' , 'barcode' => 'OZN233024311', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI черный, длина 10000 мм, высота 140 мм, арт. 82402-Ч' ),
            
    array('article' =>'82400-З', 'OzonProductID' =>'56484528' , 'sku' =>'233024178' , 'barcode' => 'OZN233024174', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI зеленый, длина 10000 мм, высота 80 мм, арт. 82400-З' ),
    array('article' =>'82401-З', 'OzonProductID' =>'56483140' , 'sku' =>'233036611' , 'barcode' => 'OZN233036607', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри зеленый, длина 10000 мм, высота 110 мм, арт. 82401-З' ),
    array('article' =>'82402-З', 'OzonProductID' =>'56485680' , 'sku' =>'233024288' , 'barcode' => 'OZN233024286', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI зеленый, длина 10000 мм, высота 140 мм, арт. 82402-З' ),
    
    array('article' =>'82400-К', 'OzonProductID' =>'56496158' , 'sku' =>'233036616' , 'barcode' => 'OZN233036608', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI коричневый, длина 10000 мм, высота 80 мм, арт. 82400-К' ),
    array('article' =>'82401-К', 'OzonProductID' =>'56494725' , 'sku' =>'233036422' , 'barcode' => 'OZN233036420', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри коричневый, длина 10000 мм, высота 110 мм, арт. 82401-К' ),
    array('article' =>'82402-К', 'OzonProductID' =>'56498464' , 'sku' =>'233029730' , 'barcode' => 'OZN233029725', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI коричневый, длина 10000 мм, высота 140 мм, арт. 82402-К' )
    
       

);
return $arr_catalog;
}

// array('article' =>'AAA', 'OzonProductID' =>'222' , 'sku' =>'544' , 'barcode' => 'OZN', 'name' => 'Решетка' ),