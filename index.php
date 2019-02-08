<?php
$is_auth = rand(0, 1);

$user_name = 'Ксения';

require_once('functions.php');
require_once('data.php');
require_once('templates\index.php');
require_once('footer.php');


$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Главная',
    'footer' => $footer
]);

print($layout_content);
?>


