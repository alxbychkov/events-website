<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
    if ($arResult["ID"]) {
        $countEvents = 0;
        $speakerID = $arResult["ID"];
        $eventsIds = [];

        if (CModule::IncludeModule("iblock")) {
            $events = [];
            $eventsElements = CIBlockElement::GetList (
                Array("ID" => "ASC"),
                Array("IBLOCK_ID" => 7),
                false,
                false,
                Array('ID', 'PROPERTY_SPEAKERS')
            );
            while($arField = $eventsElements->GetNext()) {
                if (in_array($speakerID, $arField["PROPERTY_SPEAKERS_VALUE"])) 
                    array_push($events, $arField["ID"]);
            }
            $arResult["EVENTS_LIST"] = $events;
        }
    }
?>