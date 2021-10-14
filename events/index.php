<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мероприятия");

$GLOBALS["afterToday"] = Array(">=DATE_ACTIVE_FROM" => "01.01.1970", "<=DATE_ACTIVE_FROM" => "31.12.1970");
$GLOBALS["beforeToday"] = Array(">=DATE_ACTIVE_FROM" => "01.01.1970", "<=DATE_ACTIVE_FROM" => "31.12.1970");
$GLOBALS["current_year"] = (new DateTime())->format("Y");
$today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата

if ($_REQUEST["year"] && $_REQUEST["year"] !== $GLOBALS["current_year"]) {
	if ($_REQUEST["year"] > $GLOBALS["current_year"]) 
		$GLOBALS["afterToday"] = Array(">=DATE_ACTIVE_FROM" => "01.01.".$_REQUEST["year"], "<=DATE_ACTIVE_FROM" => "31.12.".$_REQUEST["year"]);
	else
		$GLOBALS["beforeToday"] = Array(">=DATE_ACTIVE_FROM" => "01.01.".$_REQUEST["year"], "<=DATE_ACTIVE_FROM" => "31.12.".$_REQUEST["year"]);
	$GLOBALS["current_year"] = $_REQUEST["year"];
} else {
	$GLOBALS["afterToday"] = Array(array("LOGIC" => "OR", ">=DATE_ACTIVE_FROM" => $today, ">=DATE_ACTIVE_TO" => $today), "<=DATE_ACTIVE_FROM" => "31.12.".$GLOBALS["current_year"]);
	$GLOBALS["beforeToday"] = Array(">=DATE_ACTIVE_FROM" => "01.01.".$GLOBALS["current_year"], "<=DATE_ACTIVE_FROM" => $today);
	// Array(array("LOGIC" => "OR", "<=DATE_ACTIVE_FROM" => $to, "DATE_ACTIVE_FROM" => NULL), array("LOGIC" => "OR", ">=DATE_ACTIVE_TO" => $from, ">=DATE_ACTIVE_FROM" => $from));
	// $GLOBALS["beforeToday"] = Array(array(">=DATE_ACTIVE_FROM" => "01.01.".$GLOBALS["current_year"], array("LOGIC" => "OR",">=DATE_ACTIVE_TO" => $today, "DATE_ACTIVE_TO" => NULL)), array("LOGIC" => "OR", "<=DATE_ACTIVE_TO" => $today, "<=DATE_ACTIVE_FROM" => $today));
}
?><main class="main event-page">

<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"all_events", 
	array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "NAME",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.M.y g:i A",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "DATE_ACTIVE_FROM",
			7 => "ACTIVE_FROM",
			8 => "DATE_ACTIVE_TO",
			9 => "ACTIVE_TO",
			10 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Мероприятие",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "PLACE",
			1 => "PHONE",
			2 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_FIELD_CODE" => array(
			0 => "DATE_ACTIVE_FROM",
			1 => "ACTIVE_FROM",
			2 => "DATE_ACTIVE_TO",
			3 => "ACTIVE_TO",
			4 => "",
		),
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "actions",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.M.y g:i A",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_PICTURE",
			3 => "DATE_ACTIVE_FROM",
			4 => "DATE_ACTIVE_TO",
			5 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "PLACE",
			1 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "13",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "show_more",
		"PAGER_TITLE" => "Мероприятия",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/events/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "all_events",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_ID#/",
		)
	),
	false
);?>
<div class="container">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"main_events",
	Array(
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
		"COMPONENT_TEMPLATE" => "main_events",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"ID",1=>"NAME",2=>"PREVIEW_PICTURE",3=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "actions",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "200",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Вас может заинтересовать",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"PLACE",1=>"",),
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
		"STRICT_SECTION_CHECK" => "N"
	)
);?> <?$APPLICATION->IncludeComponent(
	"bitrix:subscribe.form",
	"subscribe_form",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",
		"SHOW_HIDDEN" => "N",
		"USE_PERSONALIZATION" => "Y"
	)
);?>
</div>
 </main><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>