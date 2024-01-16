<?php

function razbor_post_massive_wb($arr_post){

foreach ($arr_post as $key=>$value) {
 
    if (mb_strpos($key, 'wb_BarCode_') > 0){
        $new_key = str_replace('_wb_BarCode_', '', $key);
        $arr_BarCode[$new_key] = $value;
    }

    if (mb_strpos($key, 'wb_value_') > 0){
        $new_key = str_replace('_wb_value_', '', $key);
        $arr_value[$new_key] = $value;
    }
    
    if (mb_strpos($key, 'wb_check_')){
        $new_key = str_replace('_wb_check_', '', $key);
  // формируем массив для обновления (Где стояла галочка в строке)
        $item_quantity[$new_key] = array("sku"    => $arr_BarCode[$new_key],
                           "amount" => (int)$arr_value[$new_key]); // требуется преобразование типа на интегер

    }
}

return $item_quantity;
}

function razbor_post_massive_wbip($arr_post){

    foreach ($arr_post as $key=>$value) {
     
        if (mb_strpos($key, 'wbip_BarCode_') > 0){
            $new_key = str_replace('_wbip_BarCode_', '', $key);
            $arr_BarCode[$new_key] = $value;
        }
    
        if (mb_strpos($key, 'wbip_value_') > 0){
            $new_key = str_replace('_wbip_value_', '', $key);
            $arr_value[$new_key] = $value;
        }
        
        if (mb_strpos($key, 'wbip_check_')){
            $new_key = str_replace('_wbip_check_', '', $key);
      // формируем массив для обновления (Где стояла галочка в строке)
            $item_quantity[$new_key] = array("sku"    => $arr_BarCode[$new_key],
                               "amount" => (int)$arr_value[$new_key]); // требуется преобразование типа на интегер
    
        }
    }
    
    return $item_quantity;
    }

    function razbor_post_massive_ozon($arr_post){

        foreach ($arr_post as $key=>$value) {
         
            if (mb_strpos($key, 'ozon_BarCode_') > 0){
                $new_key = str_replace('_ozon_BarCode_', '', $key);
                $arr_BarCode[$new_key] = $value;
            }
        
            if (mb_strpos($key, 'ozon_value_') > 0){
                $new_key = str_replace('_ozon_value_', '', $key);
                $arr_value[$new_key] = $value;
            }
            
            if (mb_strpos($key, 'ozon_check_')){
                $new_key = str_replace('_ozon_check_', '', $key);
          // формируем массив для обновления (Где стояла галочка в строке)
                $item_quantity[$new_key] = array("sku"    => $arr_BarCode[$new_key],
                                   "amount" => (int)$arr_value[$new_key]); // требуется преобразование типа на интегер
        
            }
        }
        
        return $item_quantity;
        }