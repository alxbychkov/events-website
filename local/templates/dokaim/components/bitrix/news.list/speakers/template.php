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
?>
 
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<div class="speakers__item">
		<?php
			$preview_picture = '';
			$name = '';
			$lastname = '';
			$secondname = '';

			if(is_array($arItem["PREVIEW_PICTURE"])) {
				$preview_picture = $arItem["PREVIEW_PICTURE"]["SRC"];
			}
			if($arItem["PROPERTIES"]["NAME"]["VALUE"]) {
				$name = $arItem["PROPERTIES"]["NAME"]["VALUE"];
			}
			if($arItem["PROPERTIES"]["LASTNAME"]["VALUE"]) {
				$lastname = $arItem["PROPERTIES"]["LASTNAME"]["VALUE"];
			}
			if($arItem["PROPERTIES"]["SECONDNAME"]["VALUE"]) {
				$secondname = $arItem["PROPERTIES"]["SECONDNAME"]["VALUE"];
			}
		?>
		<a href="/speakers/<?=$arItem["DETAIL_PAGE_URL"];?>" class="speakers__item__wrapper" target="_blank">
			<div class="speaker__image" style="background-image: url(<?=$preview_picture;?>);"></div>
			<div class="speaker__info">
				<p class="speaker__text __name"><?=$lastname;?></p>
				<p class="speaker__text __name"><?=$name;?></p>
				<p class="speaker__text __name"><?=$secondname;?></p>
				<?if($arItem["PROPERTIES"]["POSITION"]["VALUE"]):?>
					<p class="speaker__text __position line-clamp-2"><?=$arItem["PROPERTIES"]["POSITION"]["VALUE"];?></p>
				<?endif;?>
			</div>
		</a>
	</div>
<?endforeach;?>
</div>



