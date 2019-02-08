<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function formatSumRub ($price){
    $price = ceil($price);
    if ($price > 1000){
    $price = number_format($price, 0, ' ', ' ');
    }
    $price = $price . '₽';
    return $price;
}
?>