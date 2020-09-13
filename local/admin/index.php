<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$userId          = $USER->GetID();
$userGroupIdList = CUser::GetUserGroup($userId);

if(!$USER->IsAuthorized() || !in_array($userId, $userGroupIdList))
{
    LocalRedirect('/local/admin/login/?php=index');
}
else
{
//    require_once $_SERVER["DOCUMENT_ROOT"] . "/local/admin/client/index.html";
    LocalRedirect('/local/admin/app/?php=index');
}
