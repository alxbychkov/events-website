<?
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

if($request->isPost() && $request->getPost('day')) {
    
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
    $GLOBALS["FAVORITES"] = $arUser["UF_FAVORITES"];

    $from = $request->getPost('day');
	$to = (new DateTime($from . '+1 day'))->format('d.m.Y');

	// $arrFilterDay = Array(">=DATE_ACTIVE_FROM" => $from, "<=DATE_ACTIVE_FROM" => $to);
    $arrFilterDay = Array(array("LOGIC" => "OR", "<=DATE_ACTIVE_FROM" => $to, "DATE_ACTIVE_FROM" => NULL), array("LOGIC" => "OR", ">=DATE_ACTIVE_TO" => $from, ">=DATE_ACTIVE_FROM" => $from));
    $APPLICATION->IncludeComponent(
        "bitrix:news.list", 
        "profile_events", 
        array(
            "ACTIVE_DATE_FORMAT" => "d F, H:i",
            "ADD_SECTIONS_CHAIN" => "Y",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "N",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "NAME",
                2 => "PREVIEW_PICTURE",
                3 => "DATE_ACTIVE_FROM",
                4 => "DATE_ACTIVE_TO",
                5 => "",
            ),
            "FILTER_NAME" => "arrFilterDay",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "7",
            "IBLOCK_TYPE" => "actions",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "100",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "PROPERTY_CODE" => array(
                0 => "PLACE",
                1 => "",
            ),
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_BY2" => "SORT",
            "SORT_ORDER1" => "ASC",
            "SORT_ORDER2" => "ASC",
            "STRICT_SECTION_CHECK" => "N",
            "COMPONENT_TEMPLATE" => "profile_events",
            "DAY" => $from,
        ),
        false
    );
} else {
    die();
}
?>