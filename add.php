<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');

//проверяем существует пользователь или нет
if (! isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

//обработка формы на добавление лота
$new_lot = [
    'lot_name' => 'Введите наименование лота',
    'category' => 'Выберите категорию',
    'discription' => 'Напишите описание лота',
    'initial_price' => 'Введите начальную цену',
    'step_rate' => 'Введите шаг ставки',
    'completion_date' => 'Введите дату завершения торгов'
];

$error_count = 0;

$errors[];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//здесь все что связанно с проверками заполнения

// проверка введенных данных
foreach ($new_lot as $nl => $val) {
    $add_data[$nl]['value'] = '';
    $error = false;
    
    if (isset($_POST[$nl])) {
        $data[$nl] = strip_tags(trim($_POST[$nl]));
        
        if ($data[$nl]) {
            $add_data[$nl]['value'] = $data[$nl];
            
            if (($nl == 'initial_price' || $nl == 'step_rate') && ! is_numeric($data[$nl])) {
                $error = true;
            }
        }
        else {
            $error = true;
        }
    }
    
    if ($error) {
        $error_count ++;
        $add_data[$nl]['invalid'] = ' form__item--invalid';
        $add_data['error'][$nl] = $add_data['error'][$nl] ?? $val;
    }
    else {
        $add_data[$nl]['invalid'] = '';
        $add_data['error'][$nl] = '';
    }
}
    
//список категорий
foreach ($category_list => $val) {
    if ($error_count && $data['category'] == $category_list) {
        $add_data[$category_list . '-sel'] = ' selected';
    }
    else {
        $add_data[$category_list . '-sel'] = '';
    }
}
    
//сохраняем файл
require 'app/save_img.php';
$add_data['error']['img'] = $file_error;
$add_data['uploaded'] = $uploaded_class;

// обработка ошибок
if ($error_count) {
    $add_data['error_main'] = 'Пожалуйста, исправьте ошибки в форме.';
    $add_data['invalid'] = ' form--invalid';
    $layout_data['title'] = 'Есть ошибки';
}
    if(count($errors)){
//если ошибок нет пишем в базу и делаем редирект
else {
    if (!isset($_POST['lot_name'])) {
        $add_data['invalid'] = '';
        $add_data['error_main'] = '';
    }
    else {
        $sql = 'INSERT INTO lots ('
        . 'name, discription, initial_price, step_rate, image, '
        . 'category_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $query_data = [
            $data['lot_name'],
            $data['discription'],
            floor($data['initial_price']),
            floor($data['step_rate']),
            $time,
            $data['lot-date'],
            $_SESSION['url'],
            $data['category'],
            $_SESSION['user']['id']
        ];
        
        $stmt = db_get_prepare_stmt($con, $sql, $query_data);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            $query_errors[] = 'Регистрация невозможна по техническим причинам.';
        }
        else {
            header('Location: lot.php?id=' . mysqli_insert_id($con));
            unset($_SESSION['url']);
            exit();
        }
    }
}
}
    
//отображаем список категорий
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

// "собираем" всю станицу
$add_content = include_template('lot.php', [
'footer' => $footer_content,
'title' => $lot_title
]);

print($add_content, $query_errors);

?>