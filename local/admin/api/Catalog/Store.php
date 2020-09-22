<?php

namespace LocalAdmin\Catalog;

use \Exception;

use Bitrix\Main,
    Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Catalog;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/interface/admin_lib.php");


class Store
{
    private static $status = 200;

    public function __construct()
    {
        if(!Loader::includeModule('catalog'))
        {
            echo json_encode([
                'status'  => 500,
                'message' => 'module catalog include error'
            ]);
            die;
        }
    }

    private function getSiteTitle($siteId)
    {
        static $rsSites = '';
        static $arSitesShop = array();
        $siteTitle = $siteId;

        if($rsSites === '')
        {
            $rsSites = \CSite::GetList($b="id", $o="asc", Array("ACTIVE" => "Y"));
            while($arSite = $rsSites->GetNext())
                $arSitesShop[] = array("ID" => $arSite["ID"], "NAME" => $arSite["NAME"]);
        }

        foreach($arSitesShop as $arSite)
        {
            if($arSite["ID"] == $siteId)
            {
                $siteTitle = $arSite["NAME"]." (".$arSite["ID"].")";
            }
        }
        return $siteTitle;
    }

    public function getListStore($req)
    {
        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];

        $arSelect = array(
            "ID",
            "ACTIVE",
            "TITLE",
            "ADDRESS",
            "DESCRIPTION",
            "GPS_N",
            "GPS_S",
            "IMAGE_ID",
            "PHONE",
            "SCHEDULE",
            "XML_ID",
            "DATE_MODIFY",
            "DATE_CREATE",
            "USER_ID",
            "MODIFIED_BY",
            "SORT",
            "EMAIL",
            "ISSUING_CENTER",
            "SHIPPING_CENTER",
            "SITE_ID",
            "CODE",
            "UF_*"
        );

        try
        {
            $dbResultList = \CCatalogStore::GetList([], [], false, false, $arSelect);

            $dbResultList = new \CAdminUiResult($dbResultList, "b_catalog_store");
            $dbResultList->NavStart();

            while ($arRes = $dbResultList->Fetch())
            {
                $json['data'][] = $arRes;
            }
        }
        catch (Exception $e)
        {

        }

        echo json_encode($json);
    }

    public function getListProvider($req)
    {
        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];

        $arSelect = array(
            "ID",
            "PERSON_TYPE",
            "PERSON_NAME",
            "EMAIL",
            "PHONE",
            "POST_INDEX",
            "COUNTRY",
            "CITY",
            "COMPANY",
            "INN",
            "KPP",
            "ADDRESS",
        );

        try
        {
            $dbResultList = \CCatalogContractor::GetList(
                [],
                [],
                false,
                [
                    "nPageSize" => 20
                ],
                $arSelect
            );

            $dbResultList = new \CAdminUiResult($dbResultList, 'b_catalog_contractor');
            $dbResultList->NavStart();

            while ($arResultContractor = $dbResultList->Fetch())
            {
                $json['data'][] = $arResultContractor;
            }
        }
        catch (Exception $e)
        {

        }

        echo json_encode($json);
    }

    public function getListDocument($req)
    {
        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];

        $docsOrder = [
            "ID"=> "DESC"
        ];
        $arFilter = [];
        $arSelectFields = [
            "ID",
            "DOC_TYPE",
            "STATUS",
            "DATE_DOCUMENT",
            "CREATED_BY",
            "MODIFIED_BY",
            "DATE_MODIFY",
            "CONTRACTOR_ID",
            "SITE_ID",
            "CURRENCY",
            "TOTAL",
        ];

        try
        {
            $dbResultList = \CCatalogDocs::getList($docsOrder, $arFilter, false, false, $arSelectFields);
            $dbResultList = new \CAdminUiResult($dbResultList, 'b_catalog_store_docs');

            while($arRes = $dbResultList->Fetch())
            {
                $arRes['SITE_ID_TEXT'] = $this->getSiteTitle($arRes['SITE_ID']);

                $json['data'][] = $arRes;
            }
        }
        catch (Exception $e)
        {

        }

        echo json_encode($json);
    }
}
