<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/head.php");

if($status !== 200)
{
    $tokenCsrfServer = null;
}

//check role
$roleGroupIdMap = [
    "ADMIN"         => 10,
    "CONTENT_ADMIN" => 13,
];

$groupId = $roleGroupIdMap[$_REQUEST['role']];

if(empty($groupId) || !in_array($groupId, $userGroupIdList))
{
    $status = 403;
    $status_role = 403;
}

if (CLIENT_MODE === 'DEVELOPMENT')
{
    $status = 200;
    $tokenCsrfServer = "622f4de829350ee2d3b540382e1b74a7";
}

    // todo: should be work only when user load/refresh page, for router links don't check this
    echo json_encode([
        'status'     => $status,
        '$status_role'     => $status_role,
        'TOKEN_CSRF' => $tokenCsrfServer, // todo: check
        'request' => $_REQUEST,
        '$userGroupIdList' => $userGroupIdList,
        '$groupId' => $groupId,
//        'cookie' => $_COOKIE['PHPSESSID'],
//        'phpSessId' => $phpSessId,
//        'getallheaders' => getallheaders(),
    ]);
