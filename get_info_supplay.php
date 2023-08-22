<?php
require_once "wb/functions/functions.php";
require_once "wb/functions/functions.php";

$token_wb = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjM1ZWQ5YWIyLWY4NzAtNGFkYi1hN2IwLTA0ZTUzN2NkZjdmZCJ9.gzboXCOqiAd7n6ovPCTjyTngEJtQYzMuAEx2Gu0QGXw';
$supply_id = "WB-GI-55686892";
$res = get_info_by_postavka ($token_wb, $supply_id);

echo "<pre>";

print_r($res);
