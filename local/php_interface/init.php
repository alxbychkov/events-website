<?php
#
# Константы для телефонов, емайлов и прочей статике на сайте
# сделать через asd.tplvars
#
define(NO_AVATAR_IMG, "/img/no_avatar.png");

define(SITE_TITLE, "Сайт трансляций");
define(TAG_OG_SITENAME, ".ru");
define(SITE_SALT, "");
define(INCLUDE_AREAS, "/local/include_areas");
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

/*КЛЮЧИ GOOGLE CAPTHA*/
define('SITE_KEY', '6Le9DQUbAAAAAH7tmaHDGFeij9JMse9Y8Ub_Sa-3');
define('SECRET_KEY', '6Le9DQUbAAAAALMtyeQNIRglNWbZhtLDybXUX5QG');

# Подключаем функции сайта
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/functions/functions.php');
# Подключаем обработчики сайта handlers
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/handlers/handlers.php');