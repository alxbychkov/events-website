<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$APPLICATION->AddHeadString("<script>var captcha = {'SITE_KEY':'".SITE_KEY."'}</script>");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/captcha.js");
?>


