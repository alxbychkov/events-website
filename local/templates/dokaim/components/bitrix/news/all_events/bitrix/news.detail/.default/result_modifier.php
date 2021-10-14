<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
    if ($arResult["PROPERTIES"]["GALLERY"]["VALUE"] && count($arResult["PROPERTIES"]["GALLERY"]["VALUE"]) > 0) {
        foreach($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $index => $item) {
            $imageSrc = CFile::GetPath($item); //Получаем путь к файлу.
            $arResult["PROPERTIES"]["GALLERY"]["WEBP_SRC"][] = makeWebp($imageSrc);       
        }
    }

    if ($arResult["PROPERTIES"]["SPEAKERS"]["VALUE"] && count($arResult["PROPERTIES"]["SPEAKERS"]["VALUE"]) > 0) {
        $countSpeakers = count($arResult["PROPERTIES"]["SPEAKERS"]["VALUE"]);
        $speakersIds = $arResult["PROPERTIES"]["SPEAKERS"]["VALUE"];

        if (CModule::IncludeModule("iblock")) {
            $speakers = [];
            $img_path = ''; 
            $speakerElements = CIBlockElement::GetList (
                Array("ID" => "ASC"),
                Array("IBLOCK_ID" => 8, "ID" => $speakersIds),
                false,
                false,
                Array('ID', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_NAME', 'PROPERTY_LASTNAME', 'PROPERTY_SECONDNAME', 'PROPERTY_POSITION')
            );
            while($arField = $speakerElements->GetNext()) { 
                if ($arField["PREVIEW_PICTURE"] <> '')
                    $img_path = CFile::GetPath($arField["PREVIEW_PICTURE"]);
                $speakers[] = Array(
                    "ID" => $arField["ID"],
                    "NAME" => $arField["PROPERTY_NAME_VALUE"],
                    "LASTNAME" => $arField["PROPERTY_LASTNAME_VALUE"],
                    "SECONDNAME" => $arField["PROPERTY_SECONDNAME_VALUE"],
                    "POSITION" => $arField["PROPERTY_POSITION_VALUE"],
                    "PREVIEW_SRC" => $img_path,
                    "URL" => $arField["DETAIL_PAGE_URL"]
                );
            }
            $arResult["SPEAKERS_LIST"] = $speakers;
        }
    }

    if($arResult["DETAIL_PICTURE"]) {
        $arResult["DETAIL_PICTURE"]["WEBP_SRC"] = makeWebp($arResult["DETAIL_PICTURE"]["SRC"]);
    }

    if($arResult["PROPERTIES"]["FILES"]["VALUE"]) {
        foreach($arResult["PROPERTIES"]["FILES"]["VALUE"] as $item) {
            $fileSrc = CFile::GetPath($item);
            $arResult["PROPERTIES"]["FILES"]["SRC"][] = $fileSrc;
            if($imagePreview = createrPdfPreviewImage($fileSrc)) {
                $arResult["PROPERTIES"]["FILES"]["PREVIEW_SRC"][] = $imagePreview;
            } else $arResult["PROPERTIES"]["FILES"]["PREVIEW_SRC"][] = '';
        }
    }
?>