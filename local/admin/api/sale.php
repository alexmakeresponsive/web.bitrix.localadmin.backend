<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/guard.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/api/Sale/Order.php");


switch ($_REQUEST['q'])
{
    case "getListOrderHistory":
        $Order = new LocalAdmin\Sale\Order();
        $Order->getListHistory($_REQUEST);
    break;
    case "getListPayment":
        $Order = new LocalAdmin\Sale\Order();
        $Order->getListPayment($_REQUEST);
    break;
}
