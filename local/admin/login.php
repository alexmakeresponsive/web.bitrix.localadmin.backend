<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if($USER->IsAuthorized())
{
    LocalRedirect('/local/admin/app/?php=login');
}


$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "local.admin",
    []
);
