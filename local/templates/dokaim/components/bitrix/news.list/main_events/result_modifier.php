<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
    $main_events = [];
    foreach($arResult["ITEMS"] as $index => $arItem) {
        if ($arItem["PROPERTIES"]["SHOW"]["VALUE"]) {
            if ($arItem["PREVIEW_PICTURE"]) {
                $renderImage = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], Array("width" => 480, "height" => 270), BX_RESIZE_IMAGE_EXACT, false);
                if ($renderImage) $arItem["PREVIEW_PICTURE"]["SRC"] = $renderImage["src"];
            } 
            $main_events[] = $arItem;
        }
    }
    $arResult["ITEMS"] = $main_events;
?>