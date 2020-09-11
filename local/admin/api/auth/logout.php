<?php
/**
 * @var $userId;
 * @var $userGroupIdList;
 * */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$USER->Logout();

echo json_encode([
    'message' => "logout success",
    'status' => 200,
]);
