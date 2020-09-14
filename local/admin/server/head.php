<?php

//define("CLIENT_MODE", "DEVELOPMENT");
define("CLIENT_MODE", "PRODUCTION");

switch (CLIENT_MODE)
{
    case "DEVELOPMENT":
        header("Access-Control-Allow-Headers: X-CSRF-Token");
        header("Access-Control-Allow-Origin: *");
        break;
    default:
        header("Access-Control-Allow-Origin: http://192.168.100.6");
        break;
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/helper.php");

$userId          = $USER->GetID();
$userGroupIdList = CUser::GetUserGroup($userId);

$status          = 403;
$status_role     = 403;

$status_authorized = "N";

$headers    = getallheaders();

$tokenCsrfServer = $_SESSION['CSRF_LOCAL_ADMIN'];
$tokenCsrfHeader = $headers['X-CSRF-TOKEN'];

                              $phpSessId  = getPHPSessID($headers);
if ($_COOKIE['PHPSESSID'] === $phpSessId)
{
    $status = 200;
}

if(!$USER->IsAuthorized())
{
    $status = 403;

}
else
{
    $status_authorized = "Y";
}

header("Content-Type: application/json;");
