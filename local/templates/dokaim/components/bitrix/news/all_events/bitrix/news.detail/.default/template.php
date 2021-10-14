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
$this->addExternalCss("styles.css");
?>
<?
$video_action = '';
$full = '';
$full_text = 'В избранное';
$unfollow = '';
$unfollow_text = 'Записаться';
$stream_link = '';
if(in_array($arResult['ID'], userCustomFields($USER->GetID(), 'UF_FAVORITES'))) {
	$full = ' full';
	$full_text = 'Убрать из избранного';
}
if(in_array($arResult['ID'], userCustomFields($USER->GetID(), 'UF_REGISTERED'))) {
	$unfollow = ' unfollow';
	$unfollow_text = 'Отменить запись';
}
if(in_array($arResult['ID'], userCustomFields($USER->GetID(), 'UF_PLAYED'))) {
	$video_action = 'played';
}
if ($arResult["PROPERTIES"]["STREAM_LINK"]["VALUE"]) {
	$stream_link = $arResult["PROPERTIES"]["STREAM_LINK"]["VALUE"];
}
$backurl = urlencode($APPLICATION->GetCurPageParam());
$from = $arResult["DATE_ACTIVE_FROM"]; // дата начала мероприятия
$afterEvent = (new DateTime($from . '+1 day'))->format('d.m.Y'); // дата окончания мероприятия (следующий день)

if ($arResult["DATE_ACTIVE_TO"]) $afterEvent = $arResult["DATE_ACTIVE_TO"];
$today = (new DateTime())->format('d.m.Y H:i:s'); // текущая дата

$detailPicture = $arResult["DETAIL_PICTURE"]["SRC"];
if ($arResult["DETAIL_PICTURE"]["WEBP_SRC"]) $detailPicture = $arResult["DETAIL_PICTURE"]["WEBP_SRC"];

?>
<section class="section event__head item__overlay" data-bg="<?=$arResult["DETAIL_PICTURE"]["SRC"];?>" style="background-image: url(<?=$detailPicture;?>);">
    <div class="container flex">
		<h1 class="event__title"><?=$arResult["NAME"]?></h1>
        <div class="event__head__btns">
			<?php if(strtotime($today) < strtotime($afterEvent)):?>
            	<div class="event__btn<?=$unfollow;?>" data-type="follow" data-event="<?=$arResult["ID"]?>"><?=$unfollow_text;?></div>
			<?endif;?>
            <div class="event__btn favourite<?=$full;?>" data-type="favourite" data-event="<?=$arResult["ID"]?>"></div>
        </div>
    </div>
</section>
<div class="container">
	<section class="section about-event" <?php if($arResult["PROPERTIES"]["VIDEO"]["VALUE"]) echo 'id="video"';?>>
		<h2 class="section__title">О мероприятии</h2>
		<div class="about-event__head">
			<div class="about-event__text">
			<?if($arResult["FIELDS"]["PREVIEW_TEXT"]):?>
				<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
			<?else:?>
				<p>Описание отсутствует</p>
			<?endif;?>
			</div>
			<div class="about-event__info">
			<?php if(strtotime($today) < strtotime($afterEvent)):?>
				<?php
					$place = '';
					$phone = '';
					$date = strtolower(FormatDate("d F", MakeTimeStamp($arResult['DATE_ACTIVE_FROM'])));
					if (strtotime($today) >= strtotime($from)) $date = strtolower(FormatDate("d F", MakeTimeStamp($today)));
					$time = ConvertDateTime($arResult["DATE_ACTIVE_FROM"], "HH:MI", "ru");
					if($arResult["PROPERTIES"]["PLACE"]["VALUE"]) {
						$place = $arResult["PROPERTIES"]["PLACE"]["VALUE"];
					}
					if($arResult["PROPERTIES"]["PHONE"]["VALUE"]) {
						$phone = $arResult["PROPERTIES"]["PHONE"]["VALUE"];
					}
				?>
				<p>место: <span><?=$place;?></span></p>
				<p>дата: <span><?=$date;?></span></p>
				<p>время: <span><?=$time;?></span></p>
				<?if($phone):?>
					<p>справка: <a href="tel:+<?=ParsePhone($phone);?>"><?=$phone;?></a></p>
				<?endif;?>
			<?else:?>
				<p class="end__event">Мероприятие закончилось</p>
			<?endif;?>
			</div>
		</div>
		
		<?php if(strtotime($today) >= strtotime($from) && strtotime($today) < strtotime($afterEvent)):?>
			<?php if($USER->IsAuthorized()):?>
				<div class="about-event__body with__video">
					<h2 class="section__title">Трансляция</h2>
					<?if($stream_link <> ''):?>
						<p>Ссылка на вебинар: <a href="<?=$stream_link;?>"><?=$stream_link;?></a></p>
					<?else:?>
						<p>Ссылки на вебинар еще нет</p>
					<?endif;?>
				</div>
			<?else:?>
				<div class="about-event__body">
					<h2 class="section__title">Трансляция</h2>
					<p>Мероприятие уже началось, <a href="/login/?login=yes&backurl=<?=$backurl;?>">авторизуйтесь</a> на сайте или <a href="/login/?register=yes&backurl=<?=$backurl;?>">зарегистрируйтесь</a> чтобы посмотреть запись мероприятия.</p>
				</div>
			<?endif;?>
		<?elseif (strtotime($today) >= strtotime($afterEvent)):?>
			<?php if($USER->IsAuthorized()):?>
				<?if($arResult["PROPERTIES"]["VIDEO"]["VALUE"]):?>
					<div class="about-event__body with__video">
						<h2 class="section__title">Запись мероприятия</h2>
						<div class="circle__btn play" data-type="play" data-action="<?=$video_action;?>" data-event="<?=$arResult["ID"];?>"></div>
						<video class="about-event__video" tabindex="0">
							<source src="<?=$arResult["PROPERTIES"]["VIDEO"]["VALUE"]["path"];?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
						</video>
					</div>
				<?else:?>
					<div class="about-event__body">
						<h2 class="section__title">Запись мероприятия</h2>
						<p>Запись мероприятия скоро появится</p>
					</div>					
				<?endif;?>
			<?else:?>
					<div class="about-event__body">
						<h2 class="section__title">Запись мероприятия</h2>
						<p><a href="/login/?login=yes&backurl=<?=$backurl;?>">Авторизуйтесь</a> на сайте или <a href="/login/?register=yes&backurl=<?=$backurl;?>">зарегистрируйтесь</a> чтобы посмотреть запись мероприятия.</p>
					</div>
			<?endif;?>
		<?endif;?>
		<div class="about-event__bottom">
			<?if($arResult["DETAIL_TEXT"]):?>
				<p><?=$arResult["DETAIL_TEXT"];?></p>
			<?endif;?>		
		</div>
	</section>
	<section class="section speakers">
		<h2 class="section__title">Спикеры</h2>
		<?php if($arResult["SPEAKERS_LIST"]):?>
			<div class="speakers__wrapper" id="speakersSlider">
				<?foreach ($arResult["SPEAKERS_LIST"] as $key => $value): ?>
					<div class="speakers__item">
						<a href="<?=$value["URL"];?>" class="speakers__item__wrapper" target="_blank">
							<?php
								$preview_picture = '';
								$name = '';
								$lastname = '';
								$secondname = '';
					
								if($value["PREVIEW_SRC"]) {
									$preview_picture = $value["PREVIEW_SRC"];
								}
								if($value["NAME"]) {
									$name = $value["NAME"];
								}
								if($value["LASTNAME"]) {
									$lastname = $value["LASTNAME"];
								}
								if($value["SECONDNAME"]) {
									$secondname = $value["SECONDNAME"];
								}
							?>
							<div class="speaker__image" style="background-image: url(<?=$preview_picture;?>);"></div>
							<div class="speaker__info">
								<p class="speaker__text __name"><?=$lastname;?></p>
								<p class="speaker__text __name"><?=$name;?></p>
								<p class="speaker__text __name"><?=$secondname;?></p>
								<?if($value["POSITION"]):?>
									<p class="speaker__text __position line-clamp-2"><?=$value["POSITION"];?></p>
								<?endif;?>
							</div>
						</a>
					</div>
				<?endforeach;?>
			</div>
		<?else:?>
			<div class="speakers__wrapper">
				<p>Спикеров пока нет</p>
			</div>
		<?endif;?>
	</section>
	<?php if(strtotime($today) >= strtotime($afterEvent)):?>
		<section class="section gallery">
			<h2 class="section__title">Галерея мероприятия</h2>
			<?php if($arResult["PROPERTIES"]["GALLERY"]["VALUE"] && count($arResult["PROPERTIES"]["GALLERY"]["VALUE"]) > 0):?>
				<?
					$this->addExternalCss("/local/templates/dokaim/css/lightgallery.min.css");
					$this->addExternalJs("/local/templates/dokaim/js/lightgallery.min.js");
					$count_image = count($arResult["PROPERTIES"]["GALLERY"]["VALUE"]);
					
				?>
				<div class="gallery__wrapper" id="animated-thumbnials">
					<?foreach($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $index => $item):?>
						<?
							$imageSrc = CFile::GetPath($item); //Получаем путь к файлу.
						?>
						<div data-src="<?=$imageSrc;?>" class="gallery__item gallery__image<?if($index == 0 && $count_image > 3) echo ' tall__item';?>">
							<picture>
								<?php if($arResult["PROPERTIES"]["GALLERY"]["WEBP_SRC"][$index]):?>
									<source srcset="<?=$arResult["PROPERTIES"]["GALLERY"]["WEBP_SRC"][$index];?>" type="image/webp">
								<?endif;?>
								<img src="<?=$imageSrc;?>" alt="image" loading="lazy">
							</picture>
						</div>
					<?endforeach;?>
					<?if ($count_image > 4):?>
						<div class="gallery__item empty__item">
							<div class="circle__btn arrow-down" data-type="more__img"></div>
						</div>
					<?endif;?>
				</div>
			<?else:?>
				<p>Фотографий мероприятия еще нет.</p>
			<?endif;?>
		</section>
		<?php if($arResult["PROPERTIES"]["FILES"]["SRC"] && count($arResult["PROPERTIES"]["FILES"]["SRC"]) > 0):?>
			<section class="section gallery">
				<h2 class="section__title">Материалы и презентации спикеров</h2>
				<?php if($USER->IsAuthorized()):?>
					<div class="gallery__wrapper __pdf">
						<?foreach($arResult["PROPERTIES"]["FILES"]["SRC"] as $index => $item):?>
							<a href="<?=$item;?>" class="gallery__item gallery__image" target="_blank">
								<?if($arResult["PROPERTIES"]["FILES"]["PREVIEW_SRC"][$index] != ''):?>
									<img src="<?=$arResult["PROPERTIES"]["FILES"]["PREVIEW_SRC"][$index];?>" alt="preview-image" loading="lazy">
								<?else:?>
									<p>Документ_<?=$index;?></p>
								<?endif;?>
							</a>
						<?endforeach;?>
						<?if (count($arResult["PROPERTIES"]["FILES"]["SRC"]) > 4):?>
							<div class="gallery__item empty__item">
								<div class="circle__btn arrow-down" data-type="more__img"></div>
							</div>
						<?endif;?>
					</div>
				<?else:?>
					<p><a href="/login/?login=yes&backurl=<?=$backurl;?>">Авторизуйтесь</a> на сайте или <a href="/login/?register=yes&backurl=<?=$backurl;?>">зарегистрируйтесь</a> чтобы посмотреть материалы мероприятия.</p>
				<?endif;?>
			</section>
		<?endif;?>
	<?else:?>
		<div class="events__bottom__btns">
			<button type="submit" class="form__btn" data-type="follow" data-event="<?=$arResult["ID"]?>"><?=$unfollow_text;?></button>
			<button type="submit" class="form__btn" data-type="favourite" data-event="<?=$arResult["ID"]?>"><?=$full_text;?></button>
		</div>
	<?endif;?>
</div>
