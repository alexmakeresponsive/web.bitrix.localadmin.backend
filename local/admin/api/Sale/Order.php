<?php

namespace LocalAdmin\Sale;

use \Exception;

use \Bitrix\Main\Application;
use \Bitrix\Sale\Internals\PaymentTable;
use \Bitrix\Sale\Order as BitrixOrder;
use \Bitrix\Main\Loader;


require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/interface/admin_lib.php");


class Order
{
    private static $status = 200;

    private $tableOrder;

    public function __construct()
    {
        if(!\CModule::IncludeModule("sale"))
        {
            echo json_encode([
                'status'  => 500,
                'message' => 'module iblock include error'
            ]);
            die;
        }

        $this->tableOrder = \Bitrix\Sale\Internals\OrderTable::getTableName();
    }

    public function getListHistory($req)
    {
        global $USER;

        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];


        $orderList     = [];
        $basketList = array();



        $getListParams = [
            'filter'  => [
                ">=DATE_UPDATE" => "20.08.2020"
            ],
            'group'   => [

            ],
            'select'  => [
                "ID",
                "LID",
                "LOCK_STATUS",
                "LOCK_USER_NAME",
                "DATE_INSERT",
                "DATE_UPDATE",
                "USER_ID",
                "STATUS_ID",
                "DATE_STATUS",
                "EMP_STATUS_ID",
                "PAYED",
                "DATE_PAYED",
                "EMP_PAYED_ID",
                "CANCELED",
                "DATE_CANCELED",
                "EMP_CANCELED_ID",
                "DEDUCTED",
                "MARKED",
                "DATE_MARKED",
                "EMP_MARKED_ID",
                "REASON_MARKED",
                "PRICE",
                "CURRENCY",
            ],
            'runtime' => [

            ],
            'order' => [
                "ID" => "desc"
            ],
            'limit'  => 20,
            'offset' => 0,
        ];

        $userIdFields = [
            "EMP_ALLOW_DELIVERY",
            "EMP_DEDUCTED_ID",
            "EMP_MARKED_ID",
            "EMP_STATUS_ID",
            "EMP_CANCELED_ID",
            "EMP_PAYED_ID",
            "RESPONSIBLE_ID",
        ];

        try
        {


            $dbOrderList = new \CAdminResult(\Bitrix\Sale\Internals\OrderTable::getList($getListParams), "tbl_sale_order");

            $dbOrderList->NavStart();




            while ($arOrder = $dbOrderList->NavNext())
            {

                $arOrder['DATE_UPDATE_STRING'] = $arOrder['DATE_UPDATE']->toString();

                $orderList[$arOrder['ID']] = $arOrder;


            }

//            $json['data'] = $orderList;


            $dbItemsList = \Bitrix\Sale\Internals\BasketTable::getList(array(
                'order' => array('ID' => 'ASC'),
                'filter' => array('=ORDER_ID' => array_keys($orderList))
            ));

            while ($item = $dbItemsList->fetch())
            {
                $basketList[$item['ORDER_ID']][$item['ID']] = $item;
            }


            foreach ($orderList as $orderId => $arOrder)
            {

                $arBasketItems = $basketList[$orderId];

//                $json['data'][$orderId]['baskt-items'] = $arBasketItems;
                $json['data'][$orderId]['$arOrder'] = $arOrder;

                /**
                 * build row start
                 */

                // PAYMENTS
                $payments = array();
                /** @var \Bitrix\Main\DB\Result $res */
                $res = \Bitrix\Sale\Internals\PaymentTable::getList(array(
                    'order' => array('ID' => 'ASC'),
                    'filter' => array('ORDER_ID' => $arOrder['ID'])
                ));
                while($payment = $res->fetch())
                {
                    $payments[] = $payment;
                }

                // SHIPMENTS
                $shipments = array();
                $res = \Bitrix\Sale\Internals\ShipmentTable::getList(array(
                    'order' => array('ID' => 'ASC'),
                    'filter' => array('ORDER_ID' => $arOrder['ID'], '!=SYSTEM' => 'Y')
                ));

                while($shipment = $res->fetch())
                {
                    $shipments[] = $shipment;
                }



                $json['data'][$orderId]['$arOrder']['PAYMENTS']  = $payments;
                $json['data'][$orderId]['$arOrder']['SHIPMENTS'] = $shipments;

//                $arBasketItems['']
            }



        }
        catch (Exception $e)
        {

        }

        echo json_encode($json);
    }

    public function getListPayment($req)
    {
        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];


        $params = [
            'filter'  => [

            ],
            'group'   => [

            ],
            'select'  => [
                "*",
                "COMPANY_BY_NAME"       => "COMPANY_BY.NAME",

                "RESPONSIBLE_BY_NAME"      => "RESPONSIBLE_BY.NAME",
                "RESPONSIBLE_BY_LAST_NAME" => "RESPONSIBLE_BY.LAST_NAME",

                "ORDER_ACCOUNT_NUMBER"  => "ORDER.ACCOUNT_NUMBER",

                "ORDER_USER_LOGIN"      => "ORDER.USER.LOGIN",
                "ORDER_USER_NAME"       => "ORDER.USER.NAME",
                "ORDER_USER_LAST_NAME"  => "ORDER.USER.LAST_NAME",
                "ORDER_USER_ID"         => "ORDER.USER_ID",

                "ORDER_RESPONSIBLE_ID"  => "ORDER.RESPONSIBLE_ID",
            ],
            'runtime' => [

            ],
            'order' => [
                "ORDER_ID" => "desc"
            ],
            'limit'  => 20,
            'offset' => 0,
        ];


        try
        {
            $dbResultList = new \CAdminResult(PaymentTable::getList($params), 'b_sale_order_payment');

            while ($payment = $dbResultList->Fetch())
            {
                $json['data'][] = $payment;
            }
        }
        catch (Exception $e)
        {

        }

        echo json_encode($json);
    }
}
