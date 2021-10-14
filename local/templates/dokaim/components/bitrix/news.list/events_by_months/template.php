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
$today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата
$today = strtotime($today);
$show_elements = 4;
?>
<section class="section month-events" data-type="key-events">
	<?php if($arResult["ITEMS"] && count($arResult["ITEMS"]) > 0):?>
		<?
			$pages = ceil(count($arResult["ITEMS"]) / $show_elements);
			$index = 0;	
		?>
		<?foreach($arResult["ITEMS"] as $key => $arMonth):?>
			<?$page = floor($index/$show_elements);?>
			<div class="month__wrapper <?if($page > 0) echo 'hidden';?>" data-page="<?=$page + 1;?>">
				<h2 class="section__title"><?=RU_month($key);?></h2>
				<div class="events__wrapper<?if(count($arMonth) > 2) echo ' monthSlider';?>">
					<?foreach($arMonth as $arItem):?>
						<?
							$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
							$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
						<div class="events__item">
							<?php
								$preview_picture = '';
								$active_from = '';
								$active = '';
								$place = '';
								$event_name = '';
								$full = '';
								$played = '';
								$unfollow = '';
								$unfollow_text = 'Записаться';

								if(is_array($arItem["PREVIEW_PICTURE"])) {
									$preview_picture = $arItem["PREVIEW_PICTURE"]["SRC"];
								}
								if($arItem["DISPLAY_ACTIVE_FROM"]) {
									$active_from = $arItem["DISPLAY_ACTIVE_FROM"];
									$active = strtotime($arItem["ACTIVE_FROM"]);
									if ($arItem["DATE_ACTIVE_TO"]) $active = strtotime($arItem["DATE_ACTIVE_TO"]);
								}
								if($arItem["NAME"]) {
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
							<a href="/events/<?=$arItem["DETAIL_PAGE_URL"];?>/" target="_blank" class="events__top" style="background-image: url(<?=$preview_picture;?>);">
							<?php if($today <= $active):?>
								<div class="event__btn<?=$unfollow;?>" data-type="follow" data-event="<?=$arItem["ID"]?>"><?=$unfollow_text;?></div>
							<?elseif($arItem["PROPERTIES"]["VIDEO"]["VALUE"]):?>
								<div data-href="<?=$arItem["DETAIL_PAGE_URL"];?>/#video" class="event__btn play<?=$played;?>" data-type="visit" data-event="<?=$arItem["ID"]?>"></div>
							<?endif;?>
								<div class="event__btn favourite<?=$full;?>" data-type="favourite" data-event="<?=$arItem["ID"]?>"></div>
							</a>
							<a href="/events/<?=$arItem["DETAIL_PAGE_URL"];?>/" title="<?=$event_name;?>" class="events__link" target="_blank">
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
			</div>
			<?$index++;?>
		<?endforeach;?>
	<?else:?>
		<p>Мероприятия отсутствуют</p>
	<?endif;?>
	<?if($arResult["ITEMS"] && count($arResult["ITEMS"]) > 0):?>
		<?if ($pages > 1):?>
			<div class="show__more__btn" data-type="more-months" data-current="1" data-pages="<?=$pages;?>">Еще мероприятия</div>
		<?endif?>
	<?endif;?>
</section>
