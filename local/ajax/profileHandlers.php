<?php
/**
 * возвращает json с результатами
 * 1 - Добавили мероприятие
 * 2 - Убрали мероприятие
 * 3 - Пользователь не авотризован
 * 0 - Ошибка
 */
define("NO_KEEP_STATISTIC", true); // Не собираем стату по действиям AJAX
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("NO_AGENT_STATISTIC", true);
define("BX_SECURITY_SHOW_MESSAGE", true);
define("PUBLIC_AJAX_MODE", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
$application = Application::getInstance();
$context = $application->getContext();
$request = $context->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);
$result = 0;

if($request->isPost()) {
    global $APPLICATION;
    $idEvent = 0;
    $method = 'none';

    if (file_get_contents("php://input")) {
        $json = file_get_contents("php://input");
        $json = json_decode($json);
        $idEvent = $json->id;
        $method = $json->method;
    }
    
    if ($method !== 'none' && $idEvent !== 0) {
        if($USER->IsAuthorized()) {
            $idUser = $USER->GetID();
            $rsUser = CUser::GetByID($idUser);
            $arUser = $rsUser->Fetch();
            switch ($method) {
                case 'favourite':
                    $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
                    if(!in_array($idEvent, $arElements)) // Если еще нету этой позиции в избранном
                    {
                        $arElements[] = $idEvent;
                        $result = 1;
                    }
                    else {
                        $key = array_search($idEvent, $arElements); // Находим элемент, который нужно удалить из избранного
                        unset($arElements[$key]);
                        $result = 2;
                    }
                    $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
                    break;
                case 'newfavourite':
                    $arElements = $arUser['UF_FAVORITES'];  // Достаём избранное пользователя
                    if(!in_array($idEvent, $arElements)) // Если еще нету этой позиции в избранном
                    {
                        $arElements[] = $idEvent;
                        $result = 1;
                        $USER->Update($idUser, Array("UF_FAVORITES" => $arElements)); // Добавляем элемент в избранное
                    }
                    break;
                case 'follow':
                    $arElements = $arUser['UF_REGISTERED'];  // Достаём зарегестрированные мероприятия пользователя
                    if(!in_array($idEvent, $arElements)) // Если еще нету этой позиции в зарегестрированных
                    {
                        $arElements[] = $idEvent;
                        $result = 1;
                    }
                    else {
                        $key = array_search($idEvent, $arElements); // Находим элемент, который нужно удалить из зарегестрированных
                        unset($arElements[$key]);
                        $result = 2;
                    }
                    $USER->Update($idUser, Array("UF_REGISTERED" => $arElements)); // Добавляем элемент
                    break;
                case 'newfollow':
                    $arElements = $arUser['UF_REGISTERED'];  // Достаём зарегестрированные мероприятия пользователя
                    if(!in_array($idEvent, $arElements)) // Если еще нету этой позиции в зарегестрированных
                    {
                        $arElements[] = $idEvent;
                        $result = 1;
                        $USER->Update($idUser, Array("UF_REGISTERED" => $arElements)); // Добавляем элемент
                    }
                    break;
                case 'play':
                    $arElements = $arUser['UF_PLAYED'];  // Достаём зарегестрированные мероприятия пользователя
                    if(!in_array($idEvent, $arElements)) // Если еще нету этой позиции в зарегестрированных
                    {
                        $arElements[] = $idEvent;
                        $result = 1;
                        $USER->Update($idUser, Array("UF_PLAYED" => $arElements)); // Добавляем элемент 
                    }
                    break;
                default:
                    break;
            }
        } else {
            $result = 3;
        }
    }
}

echo json_encode($result);
die();
?>