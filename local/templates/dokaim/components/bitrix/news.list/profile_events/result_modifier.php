<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as $index => $arItem) {
    if ($arItem["PREVIEW_PICTURE"]) {
        $renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 240, "height" => 135), BX_RESIZE_IMAGE_EXACT, false);
        if ($renderImage) $arResult["ITEMS"][$index]["PREVIEW_PICTURE"]["SRC"] = $renderImage["src"];
    }
    if ($arParams["FILTER_NAME"] == 'arrFilterDay') {
        if ($arItem["DATE_ACTIVE_TO"] && $arParams["DAY"]) {
            $time = (new DateTime($arItem["DATE_ACTIVE_FROM"]))->format('H:i');
            $time = (new DateTime((new DateTime($arParams["DAY"]))->format('d.m.Y') . $time))->format('d.m.Y H:i');

            if (strtotime($arItem["DATE_ACTIVE_FROM"]) < strtotime($arParams["DAY"])) {
                $nextDay = strtolower(FormatDate("d F, H:i", MakeTimeStamp((new DateTime($time))->format('d.m.Y H:i'))));
                $arResult["ITEMS"][$index]["DISPLAY_ACTIVE_FROM"] = $nextDay;
            }
        }
    }
}

?>