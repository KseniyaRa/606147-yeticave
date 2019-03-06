<?php
require_once('functions.php');
require_once('data.php');
require_once('init.php');

$errors = array();

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
        $content = include_template('/add-lot.php', [
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
        $content = include_template('/add-lot.php', [
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
}
    else {
    $content = include_template('/add-lot.php', [
        'new_lot' => $new_lot,
        'categories' => $categories
    ]);
}
    
//отображаем список категорий
$footer_content = include_template('footer.php', [
    'promo' => $promo]
);

    
$add_content = include_template('/add-lot.php', [
    'content' => $content,
    'footer' => $footer_content,
    'main_title' => 'yetiCave - добавить новый лот',
    'is_auth' => $is_auth,
    'user_name' => $_SESSION['user']['user_name'],
    'user_avatar' => $user_avatar,
]);
 
print($add_content);
    
?>