<?php

function getPHPSessID($headers)
{
    $phpSessId = null;

    $headersCookie = $headers['Cookie'];

    $cookieRequestList = explode(' ', $headersCookie);

    foreach ($cookieRequestList as $cookieRequest)
    {
        $cookieItem = explode('=', $cookieRequest);
        if ($cookieItem[0] === 'PHPSESSID')
        {
            $phpSessId = str_replace( ';', '', $cookieItem[1]);
            break;
        }
    }

    return $phpSessId;
}

function getCSRFToken($headers)
{
    return $headers['X-CSRF-TOKEN'];
}
