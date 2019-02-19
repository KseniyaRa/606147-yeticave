<?php
$is_auth = rand(0, 1);

$user_name = 'Ксения';

require_once('functions.php');
require_once('data.php');
require_once('init.php');

$page_content = include_template('index.php', [ 
    'promo' => $promo,
    'lots' => $lots]
);

$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Главная',
    'footer' => $footer_content
]);

print($layout_content);

//получаем открытые лоты
$lots_categories = get_mysql_data($con, 'SELECT * FROM category', []);

$lots_sql_query = 'SELECT lot.name, initial_price, image, /*цена*/ c.name 
FROM lot
JOIN category c
ON lot.category_id = c.id
ORDER BY lot.date DESC';

?>



