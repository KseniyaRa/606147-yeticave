<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');

$errors[]; // нет ошибок

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $new_lot = [
    'lot_name' => 'Введите наименование лота',
    'category' => 'Выберите категорию',
    'discription' => 'Напишите описание лота',
    'initial_price' => 'Введите начальную цену',
    'step_rate' => 'Введите шаг ставки',
    'completion_date' => 'Введите дату завершения торгов'
    ];
    
    //проверяем каждый пункт формы
        foreach ($new_lot as $nl => $val) {
        if ($_POST['category'] == 'categories') {
            $errors['category'] = 'Выберите категорию:';
        }
        if (empty($_POST[$val])) {
            $errors[$val] = 'Заполните это поле:';
        }
    }
    
    if (isset($_FILES['image'])) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $file_relative_path = '\uploads\\img\\';
        $file_path = __DIR__ . '\uploads\\img\\';
        $file_name = $_FILES['image']['name'];
        $file_url = $file_path . $file_name;
        
        if (!empty($tmp_name)) {
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $tmp_name);
        }
        
        if (!($file_type === "image/gif" || $file_type === "image/png" || $file_type === "image/jpeg" || $file_type === "image/jpg")) {
            $errors['image'] = 'Загрузите картинку в формате на выбор: 	png, jpg, gif';
        } 
        
        else {
            move_uploaded_file($tmp_name, $file_url);
            $lot['path'] = $file_relative_path . $file_name;
        }
    }
    else {
        $errors['image'] = "Загрузите файл";
    }
    
    if (!is_numeric($_POST['initial_price'])) {
        $errors['initial_price'] = "Введите начальную цену";
    } 
            
    if (!is_numeric($_POST['step_rate'])) {
        $errors['step_rate'] = "Введите шаг ставки";
    }
    
    if (count($errors)) {
        $content = renderTemplate('templates/add-index.php', [
            'categories' => $categories,
            'errors' => $errors,
            'new_lot' => $new_lot
        ]);
    }
    
        else {
            $sql = "INSERT INTO lots (lot_name, discription, image, date, completion_date, initial_price, step_rate, user, category ) "
            . " VALUES (?, ?, ?, NOW(), ?, ?, ?, '$author_id', ?);";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt,
            'ssssiii',
            htmlspecialchars($lot['name']),
            htmlspecialchars($lot['discription']),
            $lot['path'],
            htmlspecialchars($lot['completion_date']),
            htmlspecialchars($lot['initial_price']),
            htmlspecialchars($lot['step_rate']),
            htmlspecialchars($lot['category'])
        );
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            $lot_id = mysqli_insert_id($con);
            header("Location: lot.php?lot_id=" . $lot_id);
        }
        else {
            $content = include_template('error.php', ['error' => mysqli_error($db)]);
        }
        foreach ($categories as $key) {
            if ($key['category_id'] == intval($lot['category'])) {
                $lot['category'] = $key['category'];
                break;
            }
        }
        $content = renderTemplate('templates/lot_index.php', [
            'is_auth' => $is_auth,
            'lot' => $lot,
            'categories' => $categories,
            'title' => $lot['lot_name'],
            'category' => $lot['category'],
            'price' => $lot['initial_price'],
            'lot_description' => $lot['discription'],
            'url' => '\uploads\\img\\' . $file_name
        ]);
    }
    else {
    $content = renderTemplate('templates/add-index.php', [
        'dict' => $new_lot,
        'categories' => $categories
    ]);
}
    
//отображаем список категорий
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

    
$add_content = renderTemplate('templates/layout.php', [
    'content' => $content,
    'footer' => $footer_content,
    'main_title' => 'yetiCave - добавить новый лот',
    'is_auth' => $is_auth,
    'user_name' => $_SESSION['user']['user_name'],
    'user_avatar' => $user_avatar,
]);
 
print($add_content, $errors);
    
/*           $add_data[$nl]['value'] = '';
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
        }
    
    if(!count($errors)){
    $errors[] = 'Пожалуйста, исправьте ошибки в форме.';
    $add_data['invalid'] = ' form--invalid';
    $add_content_data['title'] = 'Есть ошибки';
}
}

//проверяем существует пользователь или нет
if (! isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

//обработка формы на добавление лота

$error_count = 0;

if ($error) {
    $error_count ++;
    $add_data[$nl]['invalid'] = ' form__item--invalid';
    $add_data['error'][$nl] = $add_data['error'][$nl] ?? $val;
}
else {
    $add_data[$nl]['invalid'] = '';
    $add_data['error'][$nl] = '';
}

else {
        
        foreach ($category_list => $val) {
            if ($error_count && $data['category'] == $category_list) {
                $add_data[$category_list . '-sel'] = ' selected';
            }
            else {
                $add_data[$category_list . '-sel'] = '';
            }
        }
    }
    
    else {
        if (!isset($_POST['lot_name'])) {
            $add_data['invalid'] = '';
            $add_data['error_main'] = '';
        }
        else {
            $sql = 'INSERT INTO lots (' . 'name, discription, initial_price, step_rate, image, '
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

require 'app/save_img.php';
$add_data['error']['img'] = $file_error;
$add_data['uploaded'] = $uploaded_class;
    

?>