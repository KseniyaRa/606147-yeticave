<?php
require_once('init.php');
require_once('lot.php');

if (!$con) {
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
