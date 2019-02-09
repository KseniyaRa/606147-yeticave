<?php
$is_auth = rand(0, 1);


$user_name = 'Ксения';

require_once('functions.php');
require_once('data.php');
require_once('templates\index.php');
require_once('footer.php');

$page_content = include_template('templates\index.php', ['content' => $content]);

$footer_content = include_template('footer.php', ['footer' => $footer]);



$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Главная',
    'footer' => $footer_content
]);

print($layout_content);
?>



