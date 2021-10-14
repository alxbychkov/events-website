<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");

$userName = $USER->GetFullName();
if (!$userName)
	$userName = $USER->GetLogin();
?>
<script>
	<?if(isset($_REQUEST["method"]) && isset($_REQUEST["event"])):?>
		<?
			$method = htmlspecialchars(stripslashes(trim($_REQUEST["method"])));
			$event = htmlspecialchars(stripslashes(trim($_REQUEST["event"])));
			$backurl = '/';
			if ($_REQUEST["backurl"]) $backurl = $_REQUEST["backurl"];
		?>
		add_to_data_profile("<?=$method;?>","<?=$event;?>").then(() => window.location.href = "<?=$backurl;?>");
	<?endif;?>
	<?if ($userName):?>
		BX.localStorage.set("user_name", "<?=CUtil::JSEscape($userName)?>", 604800);
	<?else:?>
		BX.localStorage.remove("user_name");
	<?endif?>
	<?if (isset($_REQUEST["backurl"]) && $_REQUEST["backurl"] <> '' && preg_match('#^/\w#', $_REQUEST["backurl"])):?>
		document.location.href = "<?=CUtil::JSEscape($_REQUEST["backurl"])?>";
	<?endif?>
</script>
<main class="main">
<div class="container">
	 <? if (is_string($_REQUEST["backurl"]) && mb_strpos($_REQUEST["backurl"], "/") === 0) {
		 if (!isset($_REQUEST["method"]) || !isset($_REQUEST["event"]))
			LocalRedirect($_REQUEST["backurl"]);
		}
		$APPLICATION->SetTitle("Вход на сайт");
		?>
	<p class="notetext">
		 Вы зарегистрированы и успешно авторизовались.
	</p>
	<p>
 <a href="/">Вернуться на главную страницу</a>
	</p>
</div>
 </main><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>