<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/guard.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/api/Catalog/Store.php");


switch ($_REQUEST['q'])
{
    case "getListStore":
        $Store = new LocalAdmin\Catalog\Store();
        $Store->getListStore($_REQUEST);
    break;
    case "getListProvider":
        $Store = new LocalAdmin\Catalog\Store();
        $Store->getListProvider($_REQUEST);
    break;
    case "getListDocument":
        $Store = new LocalAdmin\Catalog\Store();
        $Store->getListDocument($_REQUEST);
    break;
}
