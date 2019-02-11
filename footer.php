<?php
require_once('data.php');
require_once('functions.php');
?>

<?php foreach($promo as $value => $index): ?>
<li class="nav__item">
    <a href="pages/all-lots.html <?=$value;?>"><?=$promo[$value];?></a> 
</li>
<?php endforeach; ?>