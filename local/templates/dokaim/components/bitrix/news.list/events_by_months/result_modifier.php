<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$eventsByMonth = [];
foreach ($arResult["ITEMS"] as $key => $arItem) {
    $active_from = $arItem["DATE_ACTIVE_FROM"];
    if ($arItem["DATE_ACTIVE_TO"]) $active_from = $arItem["DATE_ACTIVE_TO"];
    $month = (new DateTime($active_from))->format('F');

    if ($arParams["FILTER_NAME"] == 'afterToday') {
        if ($arItem["DATE_ACTIVE_TO"]) {
            $today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата
            $time = (new DateTime($arItem["DATE_ACTIVE_FROM"]))->format('H:i');
            $time = (new DateTime((new DateTime())->format('d.m.Y') . $time))->format('d.m.Y H:i');

            if (strtotime($arItem["DATE_ACTIVE_FROM"]) <= strtotime($today)) {
                $nextDay = strtolower(FormatDate("d F, H:i", MakeTimeStamp((new DateTime($time))->format('d.m.Y H:i'))));
                $arItem["DISPLAY_ACTIVE_FROM"] = $nextDay;
            }
        }
    }

    if ($arItem["PREVIEW_PICTURE"]) {
        $renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 240, "height" => 135), BX_RESIZE_IMAGE_EXACT, false);
        if ($renderImage) $arItem["PREVIEW_PICTURE"]["SRC"] = $renderImage["src"];
    } 

    if (array_key_exists($month, $eventsByMonth)) {
        array_push($eventsByMonth[$month], $arItem);
    } else {
        $eventsByMonth[$month][] = $arItem;
    }
}
if ($arParams["FILTER_NAME"] == 'beforeToday') $eventsByMonth = array_reverse($eventsByMonth, true);
 
$arResult["ITEMS"] = $eventsByMonth;

?>