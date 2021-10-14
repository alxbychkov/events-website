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

<div class="news-wrapper" data-type="list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<article class="news__item" id="news-id-<?=$arItem["ID"]?>">
		<div class="news__head">
			<?if($arItem["NAME"]):?>
				<h3 class="news__title"><?=$arItem["NAME"];?></h3>
			<?endif;?>
			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
				<p class="news__date"><?=strtolower(FormatDate("d F Y", MakeTimeStamp($arItem['DATE_ACTIVE_FROM'])));?></p>
			<?endif?>
		</div>
		<div class="news__body">
			<?if(is_array($arItem["DETAIL_PICTURE"]) || is_array($arItem["PREVIEW_PICTURE"])):?>
				<div class="news__body__media">
						<?
							$previewImg = '';
							$previewWebpImg = '';
							$previewImgAlt = '';
							if ($arItem["DETAIL_PICTURE"]["SRC"]) {
								$previewImg = $arItem["DETAIL_PICTURE"]["SRC"];
								$previewImgAlt = $arItem["PREVIEW_PICTURE"]["ALT"];
								if ($arItem["DETAIL_PICTURE"]["WEBP_SRC"]) {
									$previewWebpImg = $arItem["DETAIL_PICTURE"]["WEBP_SRC"];
								}
							} else {
								$previewImg = $arItem["PREVIEW_PICTURE"]["SRC"];
								if ($arItem["PREVIEW_PICTURE"]["WEBP_SRC"]) {
									$previewWebpImg = $arItem["PREVIEW_PICTURE"]["WEBP_SRC"];
								}
							}
						?>
						<picture>
							<?if ($previewWebpImg):?>
								<source srcset="<?=$previewWebpImg;?>" type="image/webp">
							<?endif;?>
							<img src="<?=$previewImg;?>" alt="<?=$previewImgAlt;?>">
						</picture>
				</div>
			<?endif;?>
			<div class="news__body__preview">
				<?if($arItem["PREVIEW_TEXT"]):?>
					<?=$arItem["PREVIEW_TEXT"];?>
				<?endif;?>
			</div>
		</div>
		<div class="news__body__hidden">
			<?if($arItem["PROPERTIES"]["PICS_NEWS"]["SRC"] && count($arItem["PROPERTIES"]["PICS_NEWS"]["SRC"]) > 0):?>
				<div class="news__body__media few">
					<?php foreach($arItem["PROPERTIES"]["PICS_NEWS"]["SRC"] as $index => $image):?>
						<div class="few__item">
							<picture>
								<?if ($arItem["PROPERTIES"]["PICS_NEWS"]["WEBP_SRC"][$index]):?>
									<source srcset="<?=$arItem["PROPERTIES"]["PICS_NEWS"]["WEBP_SRC"][$index];?>" type="image/webp">
								<?endif;?>
								<img src="<?=$image;?>" alt="news_image">
							</picture>
						</div>
					<?endforeach;?>
				</div>
			<?endif;?>
			<div class="news__body__preview">
				<?if($arItem["DETAIL_TEXT"]):?>
					<?=$arItem["DETAIL_TEXT"];?>
				<?endif;?>
			</div>
		</div>
		<div class="read__more"><p data-type="show_full">читать дальше</p></div>
	</article>
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
