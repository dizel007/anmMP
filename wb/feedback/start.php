<?php
require_once "../functions/topen.php";
require_once "../functions/functions.php";

$token_wb_ip = 'https://feedbacks-api.wildberries.ru/api/v1/questions/count-unanswered';
$res = light_query_without_data($token_wb, $token_wb_ip);
echo "<pre>";
print_r ($res);
