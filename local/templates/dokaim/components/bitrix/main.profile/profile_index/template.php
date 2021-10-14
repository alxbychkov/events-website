<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<section class="section user">
    <h1 class="section__title">Личный кабинет</h1>
    <div class="user__wrapper">
        <div class="user__info">
			<?
				$photoID = $arResult["arUser"]['PERSONAL_PHOTO']; //Получаем ID Фотографии по ID пользователя.
				if ($photoID) {
					$avatar = CFile::GetPath($photoID); //Получаем путь к файлу.
				}
			?>
			<?if($avatar):?>
            	<div class="user__avatar" style="background-image: url(<?=$avatar;?>)"></div>
			<?else:?>
				<div class="user__avatar no__avatar"></div>
			<?endif;?>
            <div class="user__placeholders">
                <p class="user__item __name"><?=$arResult["arUser"]["NAME"];?></p>
                <p class="user__item __name"><?=$arResult["arUser"]["LAST_NAME"];?></p>
                <p class="user__item __name"><?=$arResult["arUser"]["SECOND_NAME"];?></p>
                <p class="user__item __position"><?=$arResult["arUser"]["WORK_POSITION"];?></p>
                <p class="user__item __organization"><?=$arResult["arUser"]["WORK_COMPANY"];?></p>
            </div>
        </div>
        <div class="user__edit">
            <?php
                // ссылка для выхода из личного кабинета
                $logout = $APPLICATION->GetCurPageParam(
                    "logout=yes",
                    array(
                        "login",
                        "logout",
                        "register",
                        "forgot_password",
                        "change_password"
                    )
                );
            ?>
            <a href="edit.php" class="edit__link">РЕДАКТИРОВАТЬ</a>
            <a href="<?=$logout;?>&<?=bitrix_sessid_get()?>" class="form__btn exit__profile" data-type="exit">выход</a>
        </div>
    </div>
</section>
