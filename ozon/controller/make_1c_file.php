<?php

// Из полученного массива формируем массив данных,$array_art   для создания Заказа в 1С.
$kolvo_tovarov = 0;
   foreach ($res['result']['postings'] as $posts) {
      foreach ($posts['products'] as $prods) 
        {
           $array_art[$prods['offer_id']]= @$array_art[$prods['offer_id']] + $prods['quantity'];
           $kolvo_tovarov = $kolvo_tovarov + $prods['quantity'];
        //    echo $prods['price']."<br>";
          $array_art_price[$prods['offer_id']] = array("price"    => $prods['price'],
                                                       "quantity" => $array_art[$prods['offer_id']],
                                                        "name"    => $prods['name']);
        }
 }


 if (isset($array_art_price)) {

    // Создаем файл для 1С
    $xls = new PHPExcel();
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $i=1;
    echo "<pre>";
    
    foreach ($array_art_price as $key => $items) {
    // print_r($items);	
        $sheet->setCellValue("A".$i, $key);
        $sheet->setCellValue("C".$i, $items['quantity']);
        $sheet->setCellValue("D".$i, round($items['price'], 2));
        $i++; // смешение по строкам
    
    }
    
    $objWriter = new PHPExcel_Writer_Excel2007($xls);
    $rnd100000 = "(".rand(0,100000).")";
   
    $file_name_1c_list = $date_query_ozon.$rnd100000."_file_1C.xlsx";
    $objWriter->save("../EXCEL/".$file_name_1c_list);
    $link_list_tovarov = "../EXCEL/".$file_name_1c_list;
    } 

