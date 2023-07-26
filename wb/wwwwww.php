<?php
echo "Ghbdtn";

$dir    = 'reports/';
$dirs = get_dir_catalog($dir);

echo "<pre>";

foreach ($dirs as $item) {
    $temp_dir = get_dir_catalog("reports/".$item."/");
   foreach ($temp_dir as $item_w) {
    $files_alarm = get_dir_catalog("reports/".$item."/".$item_w."/");
    print_r($files_alarm);
    foreach ($files_alarm as $item_z) {
        if ($item_z == 'not_ready_supply.xxx') {
            echo "<br>FIND DIN************************************************<br>";
            $open_orders[] = "reports/".$item."/".$item_w."/".$item_z;
        }
    }
   }
}



print_r($open_orders);

$file = 'not_ready_supply.xxx';
if(!is_file($file)){
    $contents = 'NOT READY FOR SUPPLY';           // Some simple example content.
    file_put_contents($file, $contents);     // Save our content to the file.
}


function get_dir_catalog($path) {
    $temp_dir = scandir($path."/");
    foreach ($temp_dir as $item) {
        if (($item ==".") or ($item =="..")) {
            continue;
            }
        $new_dir[] = $item;
    }
return $new_dir;
}