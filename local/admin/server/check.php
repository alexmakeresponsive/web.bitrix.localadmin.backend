<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/head.php");

if($status !== 200)
{
    $tokenCsrfServer = null;
}

if (CLIENT_MODE === 'DEVELOPMENT')
{
    $status = 200;
    $tokenCsrfServer = "622f4de829350ee2d3b540382e1b74a7";
}

    // todo: should be work only when user load/refresh page, for router links don't check this
    echo json_encode([
        'status'     => $status,
        'TOKEN_CSRF' => $tokenCsrfServer, // todo: check
//        'cookie' => $_COOKIE['PHPSESSID'],
//        'phpSessId' => $phpSessId,
//        'getallheaders' => getallheaders(),
    ]);
