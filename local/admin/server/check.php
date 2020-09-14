<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/head.php");

$spaceList = [];


if($status !== 200)
{
    $tokenCsrfServer = "";
}

if ($status == 200)
{
    $status_role = 200;

    if(in_array(13, $userGroupIdList))
    {
        array_push($spaceList, "CONTENT_ADMIN");
    }

    if(in_array(10, $userGroupIdList))
    {
        array_push($spaceList, "ADMIN");
    }

    if(empty($spaceList))
    {
        $status = 403;
        $status_role = 403;
    }
}

if (CLIENT_MODE === 'DEVELOPMENT')
{
    $status = 200;
    $status_role = 200;

    $tokenCsrfServer = "622f4de829350ee2d3b540382e1b74a7";

    $space     =  "ADMIN";
//    $spaceList = ["ADMIN", "CONTENT_ADMIN"];
    $spaceList = ["ADMIN"];
}

    // todo: should be work only when user load/refresh page, for router links don't check this
    echo json_encode([
        'status'            => $status,
        'status_role'       => $status_role,

        'status_authorized' => $status_authorized,

        'TOKEN_CSRF' => $tokenCsrfServer, // todo: check

//        'request' => $_REQUEST,
//        '$userGroupIdList' => $userGroupIdList,
//        '$groupId' => $groupId,
//        'space' => $space,
        'spaceList' => $spaceList,
//        'cookie' => $_COOKIE['PHPSESSID'],
//        'phpSessId' => $phpSessId,
//        'getallheaders' => getallheaders(),
    ]);
