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
<section class="section news">
	<h2 class="section__title"><?=$arParams["PAGER_TITLE"];?></h2>
	<div class="news-wrapper">
		<?php if($arResult["ITEMS"] && count($arResult["ITEMS"]) > 0):?>
			<?
				$arItem = $arResult["ITEMS"][0];
				$picture = '';
				if($arItem["DETAIL_PICTURE"]) {
					$picture = $arItem["DETAIL_PICTURE"]["SRC"];
				}
			?>
			<a href="/news#news-id-<?=$arItem["ID"]?>" class="first__news item__overlay" style="background-image: url(<?=$picture;?>);">
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
					<p class="news__title"><?echo $arItem["NAME"];?></p>
				<?endif;?>
				<div class="news__bottom">
					<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
						<p class="news__content line-clamp"><?echo $arItem["PREVIEW_TEXT"];?></p>
					<?endif;?>
					<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
						<p class="news__date"><?echo $arItem["DISPLAY_ACTIVE_FROM"];?></p>
					<?endif?>
				</div>
			</a>
		<?endif;?>
		<div class="all__news">
			<?foreach($arResult["ITEMS"] as $index => $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<?php if($index > 0):?>
					<a href="/news#news-id-<?=$arItem["ID"]?>" class="news__item">
						<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
							<p class="item__title"><?echo $arItem["NAME"];?></p>
						<?endif;?>
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<p class="item__date"><?echo $arItem["DISPLAY_ACTIVE_FROM"];?></p>
						<?endif?>
						<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
							<p class="item__content line-clamp"><?echo $arItem["PREVIEW_TEXT"];?></p>
						<?endif;?>
					</a>
				<?endif;?>
			<?endforeach;?>
			<a href="/news" class="form__btn">все новости</a>
		</div>
	</div>
</section>
