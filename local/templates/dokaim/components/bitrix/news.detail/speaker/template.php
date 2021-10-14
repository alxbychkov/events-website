<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$preview_picture = '';
$name = '';
$lastname = '';
$secondname = '';
$position = '';
$company = '';
$info = '';

if(is_array($arResult["PREVIEW_PICTURE"])) {
	$preview_picture = $arResult["PREVIEW_PICTURE"]["SRC"];
}
if($arResult["PROPERTIES"]["NAME"]["VALUE"]) {
	$name = $arResult["PROPERTIES"]["NAME"]["VALUE"];
}
if($arResult["PROPERTIES"]["LASTNAME"]["VALUE"]) {
	$lastname = $arResult["PROPERTIES"]["LASTNAME"]["VALUE"];
}
if($arResult["PROPERTIES"]["SECONDNAME"]["VALUE"]) {
	$secondname = $arResult["PROPERTIES"]["SECONDNAME"]["VALUE"];
}
if($arResult["PROPERTIES"]["POSITION"]["VALUE"]) {
	$position = $arResult["PROPERTIES"]["POSITION"]["VALUE"];
}
if($arResult["PROPERTIES"]["COMPANY"]["VALUE"]) {
	$company = $arResult["PROPERTIES"]["COMPANY"]["VALUE"];
}
if($arResult["DETAIL_TEXT"]) {
	$info = $arResult["DETAIL_TEXT"];
}
if ($arResult["EVENTS_LIST"]) {
	$GLOBALS["SPEAKER_EVENTS"] = $arResult["EVENTS_LIST"];
}
?>

<div class="speakers__item detail__page">
	<div class="speakers__item__wrapper">
		<div class="speaker__image" style="background-image: url(<?=$preview_picture;?>);"></div>
		<div class="speaker__info">
			<?if($lastname !== ''):?>
				<p class="speaker__text __name"><?=$lastname;?></p>
			<?endif;?>
			<?if($name !== ''):?>
				<p class="speaker__text __name"><?=$name;?></p>
			<?endif;?>
			<?if($secondname !== ''):?>
				<p class="speaker__text __name"><?=$secondname;?></p>
			<?endif;?>
			<?if($position !== ''):?>
				<p class="speaker__text __position"><?=$position;?></p>
			<?endif;?>
			<?if($company !== ''):?>
				<p class="speaker__text __organization"><?=$company;?></p>
			<?endif;?>
			<?if($info !== ''):?>
				<p class="speaker__text __about"><b>Краткая информация</b><br><?=strip_tags($info);?></p>
			<?endif;?>
		</div>
	</div>
</div>