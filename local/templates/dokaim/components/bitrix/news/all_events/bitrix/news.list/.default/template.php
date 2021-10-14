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

<?if($arResult["ITEMS"] && count($arResult["ITEMS"]) > 0):?>
	<?
		$section_title = 'Предстоящие';
		$section = 'after';
		if ($arParams["FILTER_NAME"] == 'beforeToday') {
			$section_title = 'Прошедшие';
			$section = 'before';
		}
	?>
	<section class="section month-events" data-type="key-events">
		<h2 class="section__title"><?=$section_title;?></h2>
		<div class="events__wrapper<?if(count($arResult["ITEMS"]) > 1) echo ' monthSlider';?>" data-type="list" data-id="<?=$section;?>">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
					<div class="events__item">
						<?php
							$preview_picture = '';
							$active_from = '';
							$active = '';
							$today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата
							$today = strtotime($today);
							$place = '';
							$event_name = '';
							$full = '';
							$played = '';
							$unfollow = '';
							$unfollow_text = 'Записаться';

							if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])) {
								$preview_picture = $arItem["PREVIEW_PICTURE"]["SRC"];
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
						<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" target="_blank" class="events__top" style="background-image: url(<?=$preview_picture;?>);">
						<?php if($today <= $active):?>
							<div class="event__btn<?=$unfollow;?>" data-type="follow" data-event="<?=$arItem["ID"]?>"><?=$unfollow_text;?></div>
						<?elseif($arItem["PROPERTIES"]["VIDEO"]["VALUE"]):?>
							<div data-href="<?=$arItem["DETAIL_PAGE_URL"];?>#video" class="event__btn play<?=$played;?>" data-type="visit" data-event="<?=$arItem["ID"]?>"></div>
						<?endif;?>
							<div class="event__btn favourite<?=$full;?>" data-type="favourite" data-event="<?=$arItem["ID"]?>"></div>
						</a>
						<a href="<?=$arItem["DETAIL_PAGE_URL"];?>" title="<?=$event_name;?>" class="events__link" target="_blank">
							<div class="events__bottom">
								<h4 class="event__title line-clamp-1"><?=$event_name;?></h4>
								<div class="event__content">
									<p class="event__name"><?=$place;?></p><span class="separator">|</span>
									<p class="event__date"><?=$active_from;?></p>
								</div>
							</div>
						</a>
					</div>
			<?endforeach;?>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
	</section>
<?endif;?>