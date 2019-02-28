<?php
require_once('functions.php');

date_default_timezone_set("Europe/Moscow");
?>   

<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        
        <?php foreach($promo as $value => $index): ?>
        
        <li class="promo__item promo__item--boards">
            <a class="promo__link" href="pages/all-lots.html <?=$value;?>"><?=$promo[$value];?></a>
        </li>
        
        <?php endforeach; ?>
    
    </ul>
</section>

<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        
        <?php foreach ($lots as $key => $item): ?>
        
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$item['image'];?>" width="350" height="260" alt="">                    
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=htmlspecialchars($item['name']);?></span>                    
                <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?=$item["id"]?>"><?=htmlspecialchars($item['title']);?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount"><?=htmlspecialchars(formatSumRub($item['initial_price']));?></span>
                        <span class="lot__cost"><?=htmlspecialchars(formatSumRub($item['price']));?></span>
                    </div>
                    <div class="lot__timer timer">
                        
                        <?php
                        $ts = time();
                        $ts_midnight = strtotime('tomorrow');
                        $secs_to_midnight = $ts_midnight - time();
                        $hours = floor($secs_to_midnight / 3600);
                        $minutes = floor(($secs_to_midnight % 3600) / 60);
                        print("$hours:$minutes");
                        ?>
                        
                    </div>
                </div>
            </div>
        </li>
        
        <?php endforeach; ?>
    </ul>
</section>