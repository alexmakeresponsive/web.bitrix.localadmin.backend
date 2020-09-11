<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/api/auth/head.php");

if ($tokenCsrfHeader !== $tokenCsrfServer)
{
    $status = 403;
}

if ($status !== 200)
{
    echo json_encode([
        'status' => $status,
    ]);
    die;
}
