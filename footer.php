<?php foreach($promo as $value => $index): ?>
            <li class="nav__item">
                <a href="pages/all-lots.html <?=$value;?>"><?=$promo[$value];?></a> 
            </li>
            <?php endforeach; ?>