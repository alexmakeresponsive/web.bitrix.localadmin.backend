<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/head.php");

if ($tokenCsrfHeader !== $tokenCsrfServer)
{
    $status = 403;
}

if (CLIENT_MODE === 'DEVELOPMENT')
{
    $status = 200;
}

if ($status !== 200)
{
    echo json_encode([
        'status' => $status,
    ]);
    die;
}
