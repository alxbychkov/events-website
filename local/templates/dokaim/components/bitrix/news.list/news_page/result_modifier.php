<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
    foreach($arResult["ITEMS"] as $index => $arItem) {
        if (is_array($arItem["PREVIEW_PICTURE"])) {
            $arResult["ITEMS"][$index]["PREVIEW_PICTURE"]["WEBP_SRC"] = makeWebp($arItem["PREVIEW_PICTURE"]["SRC"]);
        }
        if (is_array($arItem["DETAIL_PICTURE"])) {
            $arResult["ITEMS"][$index]["DETAIL_PICTURE"]["WEBP_SRC"] = makeWebp($arItem["DETAIL_PICTURE"]["SRC"]);
        }
        if ($arItem["PROPERTIES"]["PICS_NEWS"]["VALUE"] && count($arItem["PROPERTIES"]["PICS_NEWS"]["VALUE"]) > 0) {
            foreach($arItem["PROPERTIES"]["PICS_NEWS"]["VALUE"] as $item) {
                $imageSrc = CFile::GetPath($item); //Получаем путь к файлу.
                $arResult["ITEMS"][$index]["PROPERTIES"]["PICS_NEWS"]["SRC"][] = $imageSrc;
                $arResult["ITEMS"][$index]["PROPERTIES"]["PICS_NEWS"]["WEBP_SRC"][] = makeWebp($imageSrc);   
            }
        }
    }
?>