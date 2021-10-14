<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$no_index = array(
		"0" => 5,
		"1" => 6,
		"2" => 7,
	);
?>
<?if (!empty($arResult)):?>
	<ul class="nav__menu">
		<? foreach($arResult as $arItem):
			if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
				continue;
			?>
			<?if (!in_array($arItem["ITEM_INDEX"], $no_index)):?>
				<?if($arItem["SELECTED"]):?>
					<li class="nav__item active"><a href="<?=$arItem["LINK"]?>" class="nav__link"><?=$arItem["TEXT"]?></a></li>
				<?else:?>
					<li class="nav__item"><a href="<?=$arItem["LINK"]?>" class="nav__link"><?=$arItem["TEXT"]?></a></li>
				<?endif?>
			<?endif;?>
		<?endforeach?>
	</ul>
<?endif?>