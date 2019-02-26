<?php
$is_auth = rand(0, 1);

$user_name = 'Ксения';

require_once('functions.php');
require_once('data.php');
require_once('init.php');

//получаем открытые лоты
$lots_sql_query = 'SELECT lot.name AS title, initial_price, image, /*цена*/ c.name 
FROM lot
JOIN category c
ON lot.category_id = c.id
ORDER BY lot.date DESC';

$res = mysqli_query($con, $lots_sql_query);

if ($res) {
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

//получаем список категорий
$sql = 'SELECT `id`, `name` FROM category';
$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//главная страница с списком категорий и открытыми лотами
$page_content = include_template('index.php', [ 
    'promo' => $promo,
    'lots' => $lots]
);

//список категорий из футера
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

// "собираем" всю главную страницу
$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Главная',
    'footer' => $footer_content
]);

print($layout_content);

?>



