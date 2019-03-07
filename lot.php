<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');

//проверяем существует ли id
if (isset($_GET['id'])) {
    $lot_id = mysqli_real_escape_string($con, $_GET['id']);
    $sql_lot = "SELECT lot.name AS title, `date`, discription, image, initial_price, completion_date, step_rate, author, winner, c.name 
    FROM lot 
    JOIN category c
    ON lot.category_id = c.id WHERE lot.id = ?";
    
    $stmt = db_get_prepare_stmt($con, $sql_lot, [$lot_id]);
    mysqli_stmt_execute($stmt);//Выполняет подготовленный запрос
    $res = mysqli_stmt_get_result($stmt);//Получает результат из подготовленного запроса
    
    $lot = mysqli_fetch_all($res, MYSQLI_ASSOC);
    
    $sql = 'SELECT `id`, `name` FROM category';
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

else {
    header( "HTTP/1.1 404 Not Found" );
}

//отображаем список категорий
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

// "собираем" всю станицу с лотом
$lot_content = include_template('lot.php', [
'footer' => $footer_content,
'title' => $lot_title,
'item' => $lot[0] 
]);

print($lot_content);

?>