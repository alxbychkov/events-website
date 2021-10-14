<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><main class="main">
<div class="container">
	<section class="section">
		<h1 class="section__title page__title"><?$APPLICATION->ShowTitle(false)?></h1>
		<div class="contacts-info">
			<p class="info__item"><?= tplvar('name', true);?></p>
			<p class="info__item"><span>Адрес: </span><?= tplvar('address', true);?></p>
			<p class="info__item"><span>Телефон: </span><a href="tel:+<?= ParsePhone(tplvar('phone_1'));?>" class="info__link"><?= tplvar('phone_1', true);?></a></p>
			<p class="info__item"><span>E-mail: </span><a href="mailto:<?= tplvar('email');?>" class="info__link"><?= tplvar('email', true);?></a></p>
		</div>
	</section>
</div>
<div class="map">
<?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view", 
	".default", 
	array(
		"API_KEY" => "",
		"CONTROLS" => array(
		),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.74228263975271;s:10:\"yandex_lon\";d:37.61907247505098;s:12:\"yandex_scale\";i:15;s:10:\"PLACEMARKS\";a:4:{i:0;a:3:{s:3:\"LON\";d:37.62381842731702;s:3:\"LAT\";d:55.73661375055711;s:4:\"TEXT\";s:32:\"Наука и инновации\";}i:1;a:3:{s:3:\"LON\";d:37.62395373219245;s:3:\"LAT\";d:55.745514014505325;s:4:\"TEXT\";s:32:\"Наука и инновации\";}i:2;a:3:{s:3:\"LON\";d:37.62332536024081;s:3:\"LAT\";d:55.739930507963265;s:4:\"TEXT\";s:14:\"Росатом\";}i:3;a:3:{s:3:\"LON\";d:37.61966562832484;s:3:\"LAT\";d:55.738256896873146;s:4:\"TEXT\";s:41:\"Госкорпорация Росатом\";}}}",
		"MAP_HEIGHT" => "598",
		"MAP_ID" => "contacts",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array(
			0 => "ENABLE_SCROLL_ZOOM",
			1 => "ENABLE_DBLCLICK_ZOOM",
			2 => "ENABLE_DRAGGING",
		),
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
</div>
 </main><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>