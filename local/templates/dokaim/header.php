<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
    $assets = Bitrix\Main\Page\Asset::getInstance();
    $path = SITE_TEMPLATE_PATH;
?>
<!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
    <?php
        $APPLICATION->ShowHead();
        $assets->addString('<link rel="preload" href="'.$path.'/fonts/RST45.TTF" as="font" type="font/ttf" crossorigin>');
        $assets->addString('<link rel="preload" href="'.$path.'/fonts/RST55.TTF" as="font" type="font/ttf" crossorigin>');
        $assets->addString('<link rel="preload" href="'.$path.'/fonts/RST56.TTF" as="font" type="font/ttf" crossorigin>');
        $assets->addString('<link rel="preload" href="'.$path.'/fonts/RST75.OTF" as="font" type="font/otf" crossorigin>');
        $assets->addString('<meta name="viewport" content="width=device-width,initial-scale=1">');
        $assets->addString('<link rel="shortcut icon" type="image/x-icon" href="' . $path . '/favicon.ico" />');
        $assets->addString('<link rel="apple-touch-icon" sizes="180x180" href="' . $path . '/apple-touch-icon.png" />');
        $assets->addString('<link rel="icon" type="image/png" sizes="32x32" href="' . $path . '/favicon-32x32.png" />');
        $assets->addString('<link rel="icon" type="image/png" sizes="16x16" href="' . $path . '/favicon-16x16.png" />');
        $assets->addString('<link rel="manifest" type="image/x-icon" href="' . $path . '/site.webmanifest" />');
        $assets->addCss($path . '/css/main.css');
        $assets->addCss($path . '/css/tiny-slider.css');
    ?>
    <title><?$APPLICATION->ShowTitle();?></title>
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(80017873, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true
        });
    </script>
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <?php if(ERROR_404 !== 'Y'):?>
        <header class="header">
            <div class="header-top" data-bg="/local/templates/dokaim/img/formula_big.png">
                <div class="header-top-background">
                    <div class="container flex">
                        <div class="burger">
                            <span class="burger__line"></span>
                            <span class="burger__line"></span>
                        </div>
                        <div class="header-logos">
                            <a href="https://rosatom-academy.ru/" class="logo__link">
                                <img src="<?=$path;?>/img/logo_nii.svg" alt="logo_nii" loading="lazy">
                            </a>
                            <a href="https://www.instagram.com/homoscience_ru/" class="logo__link">
                                <img src="<?=$path;?>/img/logo_homo.svg" alt="logo_homo" loading="lazy">
                            </a>
                        </div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.auth.form", 
                            "auth_form", 
                            array(
                                "FORGOT_PASSWORD_URL" => "/login/?forgot_password=yes",
                                "PROFILE_URL" => SITE_DIR . "personal/",
                                "REGISTER_URL" => "/login",
                                "SHOW_ERRORS" => "N",
                                "COMPONENT_TEMPLATE" => "auth_form"
                            ),
                            false
                        );?>
                    </div>
                </div>
                <nav class="mobile-nav">
                    <div class="mobile-nav-wrapper">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.auth.form", 
                            "auth_form", 
                            array(
                                "FORGOT_PASSWORD_URL" => "/login/?forgot_password=yes",
                                "PROFILE_URL" => SITE_DIR . "personal/",
                                "REGISTER_URL" => "/login",
                                "SHOW_ERRORS" => "N",
                                "COMPONENT_TEMPLATE" => "auth_form"
                            ),
                            false
                        );?>
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
                    </div>
                </nav>
            </div>
            <nav class="header-nav">
                <div class="container">
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
                </div>
            </nav>
        </header>
    <?endif;?>