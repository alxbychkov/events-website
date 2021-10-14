<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<footer class="footer" data-bg="/local/templates/dokaim/img/formula_big.png">
    <div class="footer-body">
        <div class="container flex">
            <nav class="footer-item">
                <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
                    "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
                        "DELAY" => "N",	// Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",	// Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                        "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                        "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                    ),
                    false
                );?>
            </nav>
            <div class="footer-item">
                <p class="info__item"><?= tplvar('name', true);?></p>
                <p class="info__item"><span><?=GetMessage("ADDRESS_NAME");?>: </span><?= tplvar('address', true);?></p>
                <p class="info__item"><span><?=GetMessage("PHONE_NAME");?>: </span><a href="tel:+<?= ParsePhone(tplvar('phone_1'));?>" class="info__link"><?= tplvar('phone_1', true);?></a></p>
                <p class="info__item"><span><?=GetMessage("EMAIL_NAME");?>: </span><a href="mailto:<?= tplvar('email');?>" class="info__link"><?= tplvar('email', true);?></a></p>
            </div>
            <div class="footer-item">
                <a href="mailto:<?= tplvar('email');?>" class="link__email"><?= tplvar('email');?></a>
                <p class="footer__text"><?=GetMessage("SOCIAL_INFO");?></p>
                <div class="footer-social">
                    <a href="<?= tplvar('vk');?>" class="social__link"><img src="<?=$path;?>/img/vk.svg" alt="vk" class="social__item"></a>
                    <a href="<?= tplvar('fb');?>" class="social__link"><img src="<?=$path;?>/img/fb.svg" alt="fb" class="social__item"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Yandex.Metrika counter -->
<noscript><div><img src="https://mc.yandex.ru/watch/80017873" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>var allEvents = <?=json_encode(getEventsDates(7));?>;</script>
<?php
    $assets->addJs($path . '/js/tiny-slider.js');
    $assets->addJs($path . '/js/main.js');
?>
</body>
</html>