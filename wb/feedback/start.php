<?php
require_once "../functions/topen.php";
require_once "../functions/functions.php";




if (isset($_GET['wb_feedback'])) {
    if ($_GET['wb_feedback'] == "wb") {
        $token = $token_wb; 
    }
    elseif ($_GET['wb_feedback'] == "wbip") {
        $token = $token_wb_ip; 
    }else {
        echo "<br> Не выбран магазин для отзывов<br>";
        die('DIE_DIE');  
    }

} else {
    echo "<br> Не выбран магазин для отзывов<br>";
    die('DIE_DIE_DIE_DIE');
}






$dopLink = '?isAnswered=false&take=1000&skip=0&order=dateDesc)';
        
$link_wb = 'https://feedbacks-api.wildberries.ru/api/v1/feedbacks'.$dopLink;
$res = light_query_without_data($token, $link_wb);
echo "<pre>";
// print_r ($res);


// перебираем все отзывы по одному
foreach ($res['data']['feedbacks'] as $feedbacks) {
$id_feedback = $feedbacks['id'];

if (($feedbacks['productValuation'] > 4 ) && ($feedbacks['text'] =='')) {
    echo "<br> ID = $id_feedback<br>";
    write_feedback_WB($token, $id_feedback );
}


}



die('ОТЗЫВЫ ОСТАВЛЕНЫ');



function write_feedback_WB($token_wb, $id_feedback ){

$feedback_random = rand(1,5);
    $feedback_answer_1 = 'Здравствуйте, Спасибо за положительный отзыв. Будем рады снова увидеть Вас в нашем магазине.';
    $feedback_answer_2 = 'Здравствуйте! Большое спасибо за то, что нашли время для обратной связи. Нам очень приятно, что у нас есть такие отзывчивые и благодарные клиенты. Будем рады видеть вас снова';
    $feedback_answer_3 = 'Здравствуйте! Благодарим, что нашли время оставить отзыв и за хорошую оценку. Обратная связь очень важна для нас. Рады, что Вы остались довольны покупкой!';
    $feedback_answer_4 = 'Здравствуйте! Спасибо Вам за положительный отзыв и за высокую оценку качества нашего товара! Пользуйтесь с удовольствием!';
    $feedback_answer_5 = 'Здравствуйте! Благодарим за положительный отзыв. Мы рады, что Вы приобрели продукцию нашего бренда. Надеемся, и в дальнейшем Вы будете выбирать наши товары для сада и огорода. Будем ждать Вас снова.';

$temp = 'feedback_answer_'.$feedback_random;
    $feedback_answer = $$temp;
echo $feedback_answer."<br>";
    $link_wb = 'https://feedbacks-api.wildberries.ru/api/v1/feedbacks';


$data = array(
    'id' => $id_feedback,
    'text' => $feedback_answer
);

$res = patch_query_with_data($token_wb, $link_wb, $data);

print_r ($res);
}