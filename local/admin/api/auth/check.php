<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/api/auth/head.php");

if($status !== 200)
{
    $tokenCsrf = null;
}

    // todo: should be work only when user load/refresh page, for router links don't check this
    echo json_encode([
        'status'     => $status,
        'TOKEN_CSRF' => $tokenCsrfServer // todo: check
//        'cookie' => $_COOKIE['PHPSESSID'],
//        'phpSessId' => $phpSessId,
//        'getallheaders' => getallheaders(),
    ]);
