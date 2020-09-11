<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if($USER->IsAuthorized())
{
    LocalRedirect('/local/admin/client/');
}

$APPLICATION->IncludeComponent(
    "bitrix:system.auth.form",
    "local.admin",
    []
);
