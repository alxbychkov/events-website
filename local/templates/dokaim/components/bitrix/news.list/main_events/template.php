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
<?if($arResult["ITEMS"] && count($arResult["ITEMS"])):?>
	<section class="section main__events">
		<h2 class="section__title"><?=$arParams["PAGER_TITLE"];?></h2>
		<div class="slider__wrapper" id="mainSlider">
			<?foreach($arResult["ITEMS"] as $index => $arItem):?>
				<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="slider__item">
					<?php
						$preview_picture = '';
						$active_from = '';
						$active = '';
						$today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата
						$today = strtotime($today);
						$place = '';
						$event_name = '';
						$img_size = 'img__sm';
						$full = '';
						$played = '';
						$unfollow = '';
						$unfollow_text = 'Записаться';
						$square_image = '';

						if ($arItem["PROPERTIES"]["SQUARE_IMAGE"]["VALUE"]) {
							$square_image = CFile::GetPath($arItem["PROPERTIES"]["SQUARE_IMAGE"]["VALUE"]);
						}

						if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])) {
							$preview_picture = $square_image ? $square_image : $arItem["PREVIEW_PICTURE"]["SRC"];
						}
						if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]) {
							$active_from = $arItem["DISPLAY_ACTIVE_FROM"];
							$active = strtotime($arItem["ACTIVE_FROM"]);
							if ($arItem["DATE_ACTIVE_TO"]) $active = strtotime($arItem["DATE_ACTIVE_TO"]);
						}
						if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]) {
							$event_name = $arItem["NAME"];
						}
						if($arItem["PROPERTIES"]["PLACE"]["VALUE"]) {
							$place = $arItem["PROPERTIES"]["PLACE"]["VALUE"];
						}
						if ($index == 0 && count($arResult["ITEMS"]) > 2) {
							$img_size = 'img__xl';
						}
						if(in_array($arItem['ID'], userCustomFields($USER->GetID(), 'UF_FAVORITES'))) {
							$full = ' full';
						}
						if(in_array($arItem['ID'], userCustomFields($USER->GetID(), 'UF_PLAYED'))) {
							$played = ' full';
						}
						if(in_array($arItem['ID'], userCustomFields($USER->GetID(), 'UF_REGISTERED'))) {
							$unfollow = ' unfollow';
							$unfollow_text = 'Отменить запись';
						}
					?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" title="<?=$event_name;?>" target="_blank" class="slider__image <?=$img_size;?> item__overlay" style="background-image: url(<?=$preview_picture;?>);"></a>
					<div class="slider__head">
						<?php if($today <= $active):?>
							<div class="event__btn<?=$unfollow;?>" data-type="follow" data-event="<?=$arItem["ID"]?>"><?=$unfollow_text;?></div>
						<?elseif($arItem["PROPERTIES"]["VIDEO"]["VALUE"]):?>
							<div data-href="<?=$arItem["DETAIL_PAGE_URL"];?>#video" class="event__btn play<?=$played;?>" data-type="visit" data-event="<?=$arItem["ID"]?>"></div>
						<?endif;?>
						<div class="event__btn favourite<?=$full;?>" data-type="favourite" data-event="<?=$arItem["ID"]?>"></div>
					</div>
					<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" class="event__link" target="_blank">
						<div class="slider__bottom">
							<h4 class="event__title line-clamp-4"><?=$event_name;?></h4>
							<div class="event__content">
								<p class="event__name"><?=$place;?></p><span class="separator">|</span>
								<p class="event__date"><?=$active_from;?></p>
							</div>
						</div>
					</a>
				</div>
			<?endforeach;?>
		</div>
	</section> 
<?endif;?>


