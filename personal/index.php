<?php
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профиль пользователя");

$today = (new DateTime())->format('d.m.Y'); // текущая дата

$signedEvents = 0;
$favouriteEvents = 0;
$attendedEvents = 0;

$idUser = $USER->GetID();
$GLOBALS["FAVORITES"] = userCustomFields($idUser, 'UF_FAVORITES');
$registered = userCustomFields($idUser, 'UF_REGISTERED');
$GLOBALS["ATTENDED"] = userCustomFields($idUser, 'UF_PLAYED');

if ($GLOBALS["FAVORITES"] && count($GLOBALS["FAVORITES"]) > 0) {
	$favouriteEvents = count($GLOBALS["FAVORITES"]);
	$arFavouriteEvents = Array("ID" => $GLOBALS["FAVORITES"]);
}

if ($registered && count($registered) > 0) {
	$futureEvents = getFutureEvents(7);
	$showEvents = [];
	$lastEvents = [];
	foreach($registered as $key => $event) {
		if (in_array($event, $futureEvents))
			$showEvents[] = $registered[$key];
		else
			$lastEvents[] = $registered[$key];
	}
	$registered = $showEvents;
	$signedEvents = count($showEvents);
	$arSignedEvents = Array("ID" => $registered);

	$attendedEvents = count($lastEvents);
	$arAttendedEvents = Array("ID" => $lastEvents);
}

?>

<main class="main" data-type="profile">
<div class="container">
<?php
$APPLICATION->IncludeComponent("bitrix:main.profile", "profile_index", Array(
	"CHECK_RIGHTS" => "N",	// Проверять права доступа
		"SEND_INFO" => "N",	// Генерировать почтовое событие
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"USER_PROPERTY" => "",	// Показывать доп. свойства
		"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
	),
	false
);
?>

<section class="section month-events" data-type="signed-events">
    <h2 class="section__title">Мероприятия на которые Вы записались</h2>
	<?php if($signedEvents !== 0):?>
		<?php require(realpath(dirname(__FILE__)).'/registered_events.php');?>
	<?else:?>
		<div data-type="no-signed-events">
			<p>Зарегистрированных мероприятий нет</p>
			<div class="events__wrapper">
				<div class="events__item empty__btn">
					<div class="events__top flex-start">
						<a href="/events" class="circle__btn cross"></a>
					</div>
				</div>
			</div>
		</div>
	<?endif;?>
</section>

<section class="section month-events" data-type="favorite-events">
		<h2 class="section__title">Избранные мероприятия</h2>
		<?php if($favouriteEvents !== 0):?>
			<?php require(realpath(dirname(__FILE__)).'/favorite_events.php');?>
		<?else:?>
			<p data-type="no-favorite-events">Избранных мероприятий нет</p>	
		<?endif;?>
</section>

<section class="section month-events" data-type="attended-events">
		<h2 class="section__title">Мероприятия которые вы посетили</h2>
		<?php if($attendedEvents !== 0):?>
			<?php require(realpath(dirname(__FILE__)).'/attended_events.php');?>
		<?else:?>
			<p data-type="no-attended-events">Вы еще не посещали мероприятия</p>	
		<?endif;?>
</section>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_events", 
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
			3 => "",
		),
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
		"COMPONENT_TEMPLATE" => "main_events"
	),
	false
);?> 
</div>
 </main><?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>