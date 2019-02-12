<?php
$is_auth = rand(0, 1);

$user_name = 'Ксения';

require_once('functions.php');
require_once('data.php');

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
?>



