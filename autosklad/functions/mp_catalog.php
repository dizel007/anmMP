<?php
function get_catalog_wb () {
$arr_catalog = array(

/// НОВЫЕ МЕТРОВЫЕ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'7245-К-10', 'article' =>'7245-К-10' , 'sku' =>'189712714' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-45 мм', 'barcode' => '2038984453848' ),
    array('real_article' =>'7260-К-8' , 'article' =>'7260-К-8'  , 'sku' =>'189711086' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-60 мм', 'barcode' => '2038984429355' ),
    array('real_article' =>'7280-К-6' , 'article' =>'7280-К-6'  , 'sku' =>'189706433' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-80 мм', 'barcode' => '2038984344481' ),

/// НОВЫЕ МЕТРОВЫЕ С ЯКОРЯМИ
    array('real_article' =>'7245-К-10-30', 'article' =>'7245-К-10-30' , 'sku' =>'189702027' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-45 мм', 'barcode' => '2038984235932' ),
    array('real_article' =>'7260-К-8-24',  'article' =>'7260-К-8-24'  , 'sku' =>'189700575' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-60 мм', 'barcode' => '2038984167448' ),
    array('real_article' =>'7280-К-6-18',  'article' =>'7280-К-6-18'  , 'sku' =>'189697257' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-80 мм', 'barcode' => '2038984134655' ),

/// СТАРЫЕ МЕТРОВЫЕ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'7245-К-16', 'article' =>'7245-К7245-К-16' , 'sku' =>'70661636' , 'name' => 'Садовый пластиковый бордюр Контур H45', 'barcode' => '4673728485587' ),
    array('real_article' =>'7260-К-12', 'article' =>'7260-К-7260-К-12' , 'sku' =>'70661638' , 'name' => 'Садовый пластиковый бордюр Контур H60', 'barcode' => '4673728485594' ),
    array('real_article' =>'7280-К-8', 'article' =>'7280-К-7280-К-8' , 'sku' =>'70661644' , 'name' => 'Садовый пластиковый бордюр Контур H80', 'barcode' => '4673728485600' ),
    
/// ЯКОРЯ 
    array('real_article' =>'1840-30', 'article' =>'1840-301840-30' , 'sku' =>'70661648' , 'name' => 'Якорь пластиковый - 30 штук', 'barcode' => '4673728485693' ),
    array('real_article' =>'1940-10', 'article' =>'1940_1940-10' , 'sku' =>'70661651' , 'name' => 'Стальной штифт для крепления бордюра Кантри, 10 штук', 'barcode' => '4673728485624' ),
    array('real_article' =>'8910-30', 'article' =>'8910-8910-30' , 'sku' =>'74147686' , 'name' => 'Пластиковый штифт для садового бордюра, 30 штук', 'barcode' => '2028175853625' ),

/// КАНТРИ МИНИ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'82400-ч', 'article' =>'8240082400-ч' , 'sku' =>'73576082' , 'name' => 'Бордюр пластиковый Кантри MINI черный', 'barcode' => '2027940361624' ),
    array('real_article' =>'82400-з', 'article' =>'8240082400-з' , 'sku' =>'73576768' , 'name' => 'Бордюр пластиковый Кантри MINI зеленый', 'barcode' => '2027941120626' ),
    array('real_article' =>'82400-к', 'article' =>'8240082400-к' , 'sku' =>'73578046' , 'name' => 'Бордюр пластиковый Кантри MINI коричневый', 'barcode' => '2027941590627' ),

/// КАНТРИ СТАНДАРТ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'82401-ч', 'article' =>'8240182401-ч' , 'sku' =>'73579454' , 'name' => 'Бордюр пластиковый Кантри STANDART черный', 'barcode' => '2027942953629' ),
    array('real_article' =>'82401-з', 'article' =>'8240182401-з' , 'sku' =>'73581430' , 'name' => 'Бордюр пластиковый Кантри STANDART зеленый', 'barcode' => '2027944296625' ),
    array('real_article' =>'82401-к', 'article' =>'8240182401-к' , 'sku' =>'73581641' , 'name' => 'Бордюр пластиковый Кантри STANDART коричневый', 'barcode' => '2027944584623' ),
    
/// КАНТРИ МАКСИ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'82402-ч', 'article' =>'8240282402-ч' , 'sku' =>'73588455' , 'name' => 'Бордюр пластиковый Кантри MAXI черный', 'barcode' => '2027949779628' ),
    array('real_article' =>'82402-к', 'article' =>'8240282402-к' , 'sku' =>'73589814' , 'name' => 'Бордюр пластиковый Кантри MAXI коричневый', 'barcode' => '2027950653627' ),
    array('real_article' =>'82402-з', 'article' =>'8240282402-з' , 'sku' =>'73593631' , 'name' => 'Бордюр пластиковый Кантри MAXI зеленый', 'barcode' => '2027951764629' ),

/// КРУГ ПРИСТВОЛЬНЫЙ
    array('real_article' =>'7262-КП', 'article' =>'7262-КП' , 'sku' =>'161555349' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037854667927' ),
    array('real_article' =>'7262-КП(У)', 'article' =>'7262-КП(У)' , 'sku' =>'161555681' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037854674901' ),
    array('real_article' =>'7262-КП(Л)', 'article' =>'7262-КП(Л)' , 'sku' =>'162972818' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037905494007' ),
   
/// РЕШЕТКА ПРИДВЕРНАЯ
    array('real_article' =>'ANM.39*59', 'article' =>'ANM.39*59' , 'sku' =>'162972818' , 'name' => 'Решетка придверная грязезащитная сталь', 'barcode' => '2028889984622' ),
    


);
return $arr_catalog;
}


function get_catalog_wbip () {
    $arr_catalog = array(


        /// НОВЫЕ МЕТРОВЫЕ БЕЗ ЯКОРЕЙ 
    array('real_article' =>'7245-К-10', 'article' =>'7245-К-10' , 'sku' =>'189764093' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-45 мм', 'barcode' => '2038985455292' ),
    array('real_article' =>'7260-К-8' , 'article' =>'7260-К-8'  , 'sku' =>'189765982' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-60 мм', 'barcode' => '2038985502798' ),
    array('real_article' =>'7280-К-6' , 'article' =>'7280-К-6'  , 'sku' =>'189766539' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-80 мм', 'barcode' => '2038985507656' ),

/// НОВЫЕ МЕТРОВЫЕ С ЯКОРЯМИ
    array('real_article' =>'7245-К-10-30', 'article' =>'7245-К-10-30' , 'sku' =>'189305139' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-45 мм', 'barcode' => '2038972181296' ),
    array('real_article' =>'7260-К-8-24',  'article' =>'7260-К-8-24'  , 'sku' =>'189759795' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-60 мм', 'barcode' => '2038985357534' ),
    array('real_article' =>'7280-К-6-18',  'article' =>'7280-К-6-18'  , 'sku' =>'189762410' , 'name' => 'Бордюр "Контур" пластиковый черный L-1000 мм, H-80 мм', 'barcode' => '2038985408373' ),




        array('real_article' =>'7245-К-16', 'article' =>'7245-К7245-К-16' , 'sku' =>'143019465' , 'name' => 'Садовый пластиковый бордюр Контур H45', 'barcode' => '2037370544764' ),
        array('real_article' =>'7260-К-12', 'article' =>'7260-К7260-К-12' , 'sku' =>'143024794' , 'name' => 'Садовый пластиковый бордюр Контур H60', 'barcode' => '2037370641364' ),
        array('real_article' =>'7280-К-8',  'article' =>'7280-К7280-К-80' , 'sku' =>'143028009' , 'name' => 'Садовый пластиковый бордюр Контур H80', 'barcode' => '2037370780186' ),
        
        
        array('real_article' =>'1840-30', 'article' =>'1840-301840-30' , 'sku' =>'143253695' , 'name' => 'Якорь пластиковый - 30 штук', 'barcode' => '2037377297670' ),
        array('real_article' =>'1940-10', 'article' =>'1940-10' ,        'sku' =>'77486545' , 'name' => 'Стальной штифт для крепления бордюра Кантри, 10 штук', 'barcode' => '2030206658628' ),
        array('real_article' =>'8910-30', 'article' =>'8910-8910-30' ,   'sku' =>'143264397' , 'name' => 'Пластиковый штифт для садового бордюра, 30 штук', 'barcode' => '2037377479830' ),
    
        array('real_article' =>'82400-ч', 'article' =>'82552-82552-ч' , 'sku' =>'76427389' , 'name' => 'Бордюр пластиковый Кантри MINI черный', 'barcode' => '2029604984620' ),
        array('real_article' =>'82400-з', 'article' =>'82552-82552-ол' , 'sku' =>'76427722' , 'name' => 'Бордюр пластиковый Кантри MINI зеленый', 'barcode' => '2029605808628' ),
        array('real_article' =>'82400-к', 'article' =>'82552-82552-к' , 'sku' =>'76427586' , 'name' => 'Бордюр пластиковый Кантри MINI коричневый', 'barcode' => '2029605723624' ),
        
        array('real_article' =>'82401-ч', 'article' =>'82401-Ч' , 'sku' =>'134413912' , 'name' => 'Бордюр пластиковый Кантри STANDART черный', 'barcode' => '2037080068888' ),
        array('real_article' =>'82401-з', 'article' =>'82401-З' , 'sku' =>'134413914' , 'name' => 'Бордюр пластиковый Кантри STANDART зеленый', 'barcode' => '2037080069243' ),
        array('real_article' =>'82401-к', 'article' =>'82401-К' , 'sku' =>'134413913' , 'name' => 'Бордюр пластиковый Кантри STANDART коричневый', 'barcode' => '2037080069120' ),
        
        array('real_article' =>'82402-ч', 'article' =>'8240282402-ч' , 'sku' =>'142950540' , 'name' => 'Бордюр пластиковый Кантри MAXI черный', 'barcode' => '2037368698509' ),
        array('real_article' =>'82402-к', 'article' =>'8240282402-к' , 'sku' =>'142950539' , 'name' => 'Бордюр пластиковый Кантри MAXI коричневый', 'barcode' => '2037368698714' ),
        array('real_article' =>'82402-з', 'article' =>'8240282402-з' , 'sku' =>'142950541' , 'name' => 'Бордюр пластиковый Кантри MAXI зеленый', 'barcode' => '2037368698400' ),
    
        array('real_article' =>'7262-КП',     'article' =>'7262-КП' , 'sku' =>'161540374' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037854333280' ),
        array('real_article' =>'7262-КП(У)', 'article' =>'7262-КП(У)' , 'sku' =>'161543753' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037854411704' ),
        array('real_article' =>'7262-КП(Ле)', 'article' =>'7262-КП(Ле)' , 'sku' =>'162976498' , 'name' => 'Садовый приствольный круг КОНТУР-КП-60.06', 'barcode' => '2037905601627' ),
        
    
    
    );  
return $arr_catalog;
}

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
            
            array('article' =>'1940-10', 'OzonProductID' =>'56869659' , 'sku' =>'233924852' , 'barcode' => 'OZN233924852', 'name' => 'Крепящий якорь к бордюру ANMAKS Кантри. Оцинкованная сталь. 10 штук, арт. 1940-10' ),
            array('article' =>'1840-30', 'OzonProductID' =>'246108361' , 'sku' =>'521884851' , 'barcode' => 'OZN521884851', 'name' => 'Крепящий якорь ANMAKS универсальный. Пластик. 30 штук, арт. 1840-30' ),
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
        
            array('article' =>'82400-Ч', 'OzonProductID' =>'56476066' , 'sku' =>'233035516' , 'barcode' => 'OZN233035516', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI черный, длина 10000 мм, высота 80 мм, арт. 82400-Ч' ),
            array('article' =>'82401-Ч', 'OzonProductID' =>'56471829' , 'sku' =>'232956898' , 'barcode' => 'OZN232956898', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри черный, длина 10000 мм, высота 110 мм, арт. 82401-Ч' ),
            array('article' =>'82402-Ч', 'OzonProductID' =>'56479147' , 'sku' =>'233024314' , 'barcode' => 'OZN233024311', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI черный, длина 10000 мм, высота 140 мм, арт. 82402-Ч' ),
                    
            array('article' =>'82400-З', 'OzonProductID' =>'56484528' , 'sku' =>'233024174' , 'barcode' => 'OZN233024174', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI зеленый, длина 10000 мм, высота 80 мм, арт. 82400-З' ),
            array('article' =>'82401-З', 'OzonProductID' =>'56483140' , 'sku' =>'233036607' , 'barcode' => 'OZN233036607', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри зеленый, длина 10000 мм, высота 110 мм, арт. 82401-З' ),
            array('article' =>'82402-З', 'OzonProductID' =>'56485680' , 'sku' =>'233024288' , 'barcode' => 'OZN233024286', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI зеленый, длина 10000 мм, высота 140 мм, арт. 82402-З' ),
            
            array('article' =>'82400-К', 'OzonProductID' =>'56496158' , 'sku' =>'233036608' , 'barcode' => 'OZN233036608', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI коричневый, длина 10000 мм, высота 80 мм, арт. 82400-К' ),
            array('article' =>'82401-К', 'OzonProductID' =>'56494725' , 'sku' =>'233036420' , 'barcode' => 'OZN233036420', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри коричневый, длина 10000 мм, высота 110 мм, арт. 82401-К' ),
            array('article' =>'82402-К', 'OzonProductID' =>'56498464' , 'sku' =>'233029730' , 'barcode' => 'OZN233029725', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI коричневый, длина 10000 мм, высота 140 мм, арт. 82402-К' )
            
               
        
        );
        return $arr_catalog;
        }



    // function get_catalog_ozon () {
    //     $arr_catalog = array(
    //     // метровый комплекты с якорями
    //         array('article' =>'7245-К-10-30', 'OzonProductID' =>'718694111' , 'sku' =>'1282704105', 'barcode' => 'OZN1282704105', 'name' => '7245-К-10-30 Экобордюр КОНТУР Б-100.05.08 пластиковый черный L-1000 мм, H-45 мм, (УПАКОВКА 10 шт. плюс 30 якорей)' ),
    //         array('article' =>'7260-К-8-24',  'OzonProductID' =>'718761682' , 'sku' =>'1282759434', 'barcode' => 'OZN1282759434', 'name' => '7260-К-8-24 Экобордюр КОНТУР Б-100.06.08 пластиковый черный L-1000 мм, H-60 мм, (УПАКОВКА 8 шт. плюс 24 якоря)' ),
    //         array('article' =>'7280-К-6-18',  'OzonProductID' =>'718765125' , 'sku' =>'1282760677', 'barcode' => 'OZN1282760677', 'name' => '7280-К-6-18 Экобордюр КОНТУР Б-100.08.08 пластиковый черный L-1000 мм, H-80 мм, (УПАКОВКА 6 шт. плюс 18 якорей)' ),
    //     // метровый комплекты БЕЗ якорей
    //         array('article' =>'7245-К-10', 'OzonProductID' =>'718804156' , 'sku' =>'1282804426', 'barcode' => 'OZN1282704105', 'name' => '7245-К-10 Экобордюр КОНТУР Б-100.05.08 пластиковый черный L-1000 мм, H-45 мм, (УПАКОВКА 10 шт.)' ),
    //         array('article' =>'7260-К-8',  'OzonProductID' =>'718808591' , 'sku' =>'1282808793', 'barcode' => 'OZN1282808793', 'name' => '7260-К-8 Экобордюр КОНТУР Б-100.06.08 пластиковый черный L-1000 мм, H-60 мм, (УПАКОВКА 8 шт.)' ),
    //         array('article' =>'7280-К-6',  'OzonProductID' =>'719799118' , 'sku' =>'1283708573', 'barcode' => 'OZN1283708573', 'name' => '7280-К-6 Экобордюр КОНТУР Б-100.08.08 пластиковый черный L-1000 мм, H-80 мм, (УПАКОВКА 6 шт.)' ),
        
    //     // метровый СТАРЫЕ комплекты 
    //         array('article' =>'7245-К-16', 'OzonProductID' =>'246532300' , 'sku' =>'522674167', 'barcode' => 'OZN522674166', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 45 мм, 16 штук' ),
    //         array('article' =>'7260-К-12', 'OzonProductID' =>'246533379' , 'sku' =>'522675673' , 'barcode' => 'OZN522675674', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 60 мм, 12 штук, арт. 7260-К-12' ),
    //         array('article' =>'7280-К-8', 'OzonProductID' =>'246534375' , 'sku' =>'522678569' , 'barcode' => 'OZN522678568', 'name' => 'Пластиковый садовый бордюр ANMAKS (Экобордюр Контур), длина 1000 мм, высота 80 мм, 8 штук, арт. 7280-К-8' ),
            
    //         array('article' =>'7280', 'OzonProductID' =>'336594806' , 'sku' =>'664665914' , 'barcode' => 'OZN664665913', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 80 мм, 1 штука, арт. 7280-К-1' ),
    //         array('article' =>'7260', 'OzonProductID' =>'336604105' , 'sku' =>'664697071' , 'barcode' => 'OZN664697072', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 60 мм, 1 штука, арт. 7260-К-1' ),
    //         array('article' =>'7245', 'OzonProductID' =>'336618823' , 'sku' =>'664720473' , 'barcode' => 'OZN664720472', 'name' => 'Пластиковый садовый бордюр ANMAKS, длина 1000 мм, высота 45 мм, 1 штука, арт. 7245-К-1' ),
            
    //         array('article' =>'1940-10', 'OzonProductID' =>'56869659' , 'sku' =>'233924855' , 'barcode' => 'OZN233924852', 'name' => 'Крепящий якорь к бордюру ANMAKS Кантри. Оцинкованная сталь. 10 штук, арт. 1940-10' ),
    //         array('article' =>'1840-30', 'OzonProductID' =>'246108361' , 'sku' =>'521884852' , 'barcode' => 'OZN521884851', 'name' => 'Крепящий якорь ANMAKS универсальный. Пластик. 30 штук, арт. 1840-30' ),
    //         array('article' =>'8910-30', 'OzonProductID' =>'246816740' , 'sku' =>'523170684' , 'barcode' => 'OZN523170685', 'name' => 'Крепящий анкер универсальный ANMAKS пластиковый, 30 штук, арт. 8910-30' ),
         
    //         array('article' =>'ANM.39*59', 'OzonProductID' =>'244184619' , 'sku' =>'518682944' , 'barcode' => 'OZN518682943', 'name' => 'Решетка придверная грязезащитная стальная ANMAKS, 39 х 59 cм' ),
    //         array('article' =>'ANM.49*99', 'OzonProductID' =>'232157194' , 'sku' =>'500199266' , 'barcode' => 'OZN500199267', 'name' => 'Решетка придверная грязезащитная стальная ANMAKS, 49 х 99 cм' ),
            
    //         array('article' =>'508АК', 'OzonProductID' =>'236917988' , 'sku' =>'507383556' , 'barcode' => 'OZN507383557', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая оцинкованная под крепеж, 1000х136 мм' ),
    //         array('article' =>'503А', 'OzonProductID' =>'237377794' , 'sku' =>'508149302' , 'barcode' => 'OZN508149303', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая из нержавеющей стали, 1000х136 мм' ),
    //         array('article' =>'508А', 'OzonProductID' =>'236935930' , 'sku' =>'508336745' , 'barcode' => 'OZN508336744', 'name' => 'Решетка водоприемная ANMAKS DN100 стальная оцинкованная, 1000х136 мм' ),
        
            
    //         array('article' =>'508А-10', 'OzonProductID' =>'237381288' , 'sku' =>'508143277' , 'barcode' => 'OZN508143276', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая стальная оцинкованная, 1000х136 мм. Комплект - 10 штук' ),
    //         array('article' =>'508АК-10', 'OzonProductID' =>'237528047' , 'sku' =>'508352124' , 'barcode' => 'OZN508352129', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая оцинкованная, 1000х136 мм.  Под крепеж. Комплект - 10 штук' ),
    //         array('article' =>'503А-10', 'OzonProductID' =>'240822865' , 'sku' =>'513511679' , 'barcode' => 'OZN513511677', 'name' => 'Решетка водоприемная ANMAKS DN100 щелевая из нержавеющей стали, 1000х136 мм. Комплект - 10 штук' ),
            
    //         array('article' =>'7262-КП', 'OzonProductID' =>'520076890' , 'sku' =>'985937305' , 'barcode' => 'OZN985937306', 'name' => 'Садовый приствольный круг ANMAKS КОНТУР-КП-60.06' ),
        
    //         array('article' =>'82400-Ч', 'OzonProductID' =>'56476066' , 'sku' =>'233035518' , 'barcode' => 'OZN233035516', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI черный, длина 10000 мм, высота 80 мм, арт. 82400-Ч' ),
    //         array('article' =>'82401-Ч', 'OzonProductID' =>'56471829' , 'sku' =>'232956901' , 'barcode' => 'OZN232956898', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри черный, длина 10000 мм, высота 110 мм, арт. 82401-Ч' ),
    //         array('article' =>'82402-Ч', 'OzonProductID' =>'56479147' , 'sku' =>'233024314' , 'barcode' => 'OZN233024311', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI черный, длина 10000 мм, высота 140 мм, арт. 82402-Ч' ),
                    
    //         array('article' =>'82400-З', 'OzonProductID' =>'56484528' , 'sku' =>'233024178' , 'barcode' => 'OZN233024174', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI зеленый, длина 10000 мм, высота 80 мм, арт. 82400-З' ),
    //         array('article' =>'82401-З', 'OzonProductID' =>'56483140' , 'sku' =>'233036611' , 'barcode' => 'OZN233036607', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри зеленый, длина 10000 мм, высота 110 мм, арт. 82401-З' ),
    //         array('article' =>'82402-З', 'OzonProductID' =>'56485680' , 'sku' =>'233024288' , 'barcode' => 'OZN233024286', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI зеленый, длина 10000 мм, высота 140 мм, арт. 82402-З' ),
            
    //         array('article' =>'82400-К', 'OzonProductID' =>'56496158' , 'sku' =>'233036616' , 'barcode' => 'OZN233036608', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MINI коричневый, длина 10000 мм, высота 80 мм, арт. 82400-К' ),
    //         array('article' =>'82401-К', 'OzonProductID' =>'56494725' , 'sku' =>'233036422' , 'barcode' => 'OZN233036420', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри коричневый, длина 10000 мм, высота 110 мм, арт. 82401-К' ),
    //         array('article' =>'82402-К', 'OzonProductID' =>'56498464' , 'sku' =>'233029730' , 'barcode' => 'OZN233029725', 'name' => 'Пластиковый садовый бордюр ANMAKS Кантри MAXI коричневый, длина 10000 мм, высота 140 мм, арт. 82402-К' )
            
               
        
    //     );
    //     return $arr_catalog;
    //     }

function get_need_ostatok () {
    $arr_need_ostatok = array (
        'ANM.39*59'    =>  20,
        'ANM.49*99'    =>  20,
        '503А'         =>  20,
        '503А-10'      =>  20,
        '508А'         =>  20,
        '508А-10'      =>  20,
        '508АК'        =>  20,
        '508АК-10'     =>  20,
        '7245'         =>  100,
        '7245-К-10'    =>  50,
        '7245-К-10-30' =>  50,
        '7245-К-16'    =>  50,
        '7260'         =>  100,
        '7260-К-12'    =>  50,
        '7260-К-8'     =>  50,
        '7260-К-8-24'  =>  50,
        '7262-КП'      =>  50,
        '7262-КП(Л)'   =>  25,
        '7262-КП(ЛЕ)'  =>  25,
        '7262-КП(У)'   =>  25,
        '7280'         =>  100,
        '7280-К-6'     =>  50,
        '7280-К-6-18'  =>  50,
        '7280-К-8'     =>  50,
        '8910-30'      =>  100,
        '1840-30'      =>  100,
        '1940-10'      =>  100,
        '82400-З'      =>  100,
        '82400-К'      =>  200,
        '82400-Ч'      =>  200,
        '82401-З'      =>  200,
        '82401-К'      =>  200,
        '82401-Ч'      =>  200,
        '82402-З'      =>  100,
        '82402-К'      =>  100,
        '82402-Ч'      =>  100

    );

    return $arr_need_ostatok;
}