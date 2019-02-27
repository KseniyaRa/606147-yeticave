<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');


//получаем список категорий
$sql = 'SELECT `id`, `name` FROM category';
$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//отображаем список категорий
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

//получаем название лота для заголовка страницы
$title = 'SELECT lot.name AS title FROM lot WHERE id = 13'; 
$res = mysqli_query($con, $title);
if ($res) {
    $lot_title = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// "собираем" всю станицу с лотом
$lot_content = include_template('lot.php', [
	'footer' => $footer_content,
	'title' => $lot_title
]);

print($lot_content);

//проверяем существует ли id
$id = mysqli_real_escape_string($con, $_GET['id']);
if (isset($_GET['id'])) {
    $lot_id = intval($_GET['id']);
    $sql_lot = "SELECT lot.name AS title, date, description, image, initial_price, completion_date, step_rate, author, winner, c.name 
    FROM lot 
    JOIN category c
    ON lot.category_id = c.id WHERE id = '$lot_id'";
    $result = mysqli_prepare($con, $sql_lot);
}
 
else {
    print('404 Страница не найдена');
}


/*if (!$con) {
    $error = mysqli_connect_error();
    show_error($content, $error);
}
else {
    $sql = 'SELECT `id`, `name` FROM category';
    $result = mysqli_query($con, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($con);
        show_error($content, $error);
    }

    $content = include_template('lot.php', ['category' => $categories]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];
//добавить картинку для Лота
        $filename = uniqid() . '.img';
        $lot['path'] = $filename;
        move_uploaded_file($_FILES['lot_img']['tmp_name'], 'uploads/' . $filename);

        $sql = 'INSERT INTO lot (name, image, category_id, description) VALUES (?, ?, ?, ?)';
        
        $stmt = db_get_prepare_stmt($con, $sql, [$lot['name'], $lot['image'], $lot['category_id'], $lot['description']]);
        $res = mysqli_stmt_execute($stmt);
        
        if ($res) {
            $lot_id = mysqli_insert_id($con);

            header("Location: lot.php?id=" . $lot_id);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($con)]);
        }
    }
}
*/