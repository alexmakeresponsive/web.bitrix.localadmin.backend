<?php

namespace LocalAdmin;

use mysql_xdevapi\Exception;

require_once($_SERVER["DOCUMENT_ROOT"] . "/local/admin/server/guard.php");

class IBlock
{
    private static $status = 200;

    public function __construct()
    {
        if(!\CModule::IncludeModule("iblock"))
        {
            echo json_encode([
                'status'  => 500,
                'message' => 'module iblock include error'
            ]);
            die;
        }
    }

    public function getListIblock()
    {
        $dataCheck = [];
        $d = [];
        $i = 0;
        $j = 0;

        $typeSkipList = ['catalog', 'offers', "rest_entity"];

                                $db_iblock_type = \CIBlockType::GetList();
        while($ar_iblock_type = $db_iblock_type->Fetch())
        {
            if(in_array($ar_iblock_type['ID'], $typeSkipList))
            {
                continue;
            }

            if($arIBType = \CIBlockType::GetByIDLang($ar_iblock_type["ID"], 'ru'))
            {
                $d[$i] = array_merge($ar_iblock_type, ['NAME' => $arIBType["NAME"]]);
            }
            else
            {
                $d[$i] = $ar_iblock_type;
            }

                            $res = \CIBlock::GetList(
                                Array(),
                                Array(
                                    'TYPE'      => $ar_iblock_type['ID'],
                                    'SITE_ID'   => 's1',
                                    'ACTIVE'    =>'Y',
                                    'CHECK_PERMISSIONS'    =>'N',
                                ), true
                            );
            while($ar_res = $res->Fetch())
            {
                $d[$i]['LIST_CHILD'][$j] = $ar_res;

                $j++;
            }

            $i++;
        }

        echo json_encode([
            'status'  => self::$status,
            'data' => $d,
        ]);
    }

    public function getListIblockSection($id)
    {
        $arLincs = [];

        $filter = array('IBLOCK_ID' => $id);
        $select = ['NAME'];

        $dbSection = \CIBlockSection::GetList(
            Array(
//                'LEFT_MARGIN' => 'ASC',
            ),
            array_merge(
                Array(
                    'ACTIVE' => 'Y',
                    'GLOBAL_ACTIVE' => 'Y'
                ),
                is_array($filter) ? $filter : Array()
            ),
            false,
            array_merge(
                Array(
                    'ID',
                    'IBLOCK_SECTION_ID'
                ),
                is_array($select) ? $select : Array()
            )
        );

        while( $arSection = $dbSection->GetNext(true, false) ){

            $SID = $arSection['ID'];
            $PSID = (int) $arSection['IBLOCK_SECTION_ID'];

            $arLincs[$PSID]['CHILDS'][$SID] = $arSection;

            $arLincs[$SID] = &$arLincs[$PSID]['CHILDS'][$SID];
        }

        $parent = array_shift($arLincs);

        echo json_encode([
            'status'  => self::$status,
            'data' => $parent['CHILDS'],
            'id'   => $id,
        ]);
    }

    public function getListIblockElement($id, $idsection, $nPageSize)
    {
        $d = [];
        $i = 0;

        if(empty($idsection))
        {
            $idsection = 0;
        }

        $arFilter = Array(
            "IBLOCK_ID"=>IntVal($id),
            "SECTION_ID" => $idsection,
            "ACTIVE"=>"Y"
        );
        $res = \CIBlockElement::GetList([], $arFilter, false, ["nPageSize"=>$nPageSize], []);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $d[] = $arFields;
        }

        echo json_encode([
            'status'  => self::$status,
            'data' => $d,
            'id'          => $id,
            'idsection'   => $idsection,
        ]);
    }

    public function getIblockElement($idIBlock, $idElement)
    {
        $d = [];

        $res = \CIBlockElement::GetByID($idElement);
        if($ar_res = $res->GetNext())
        {
            $d = $ar_res;
        }


        echo json_encode([
            'status'  => self::$status,
            'data'    => $d,
            'id'          => $idIBlock,
            'idElement'   => $idElement,
        ]);
    }

    public function getIblockSection($idSection)
    {
        $json = [
            'status'  => self::$status,
            'data'    => null,
        ];

        try
        {
            $res = \CIBlockSection::GetByID($idSection);

            $ar_res = $res->GetNext();

            $json['data'] = $ar_res;
        }
        catch (Exception $e)
        {
            self::$status = 500;
            $json = array_merge($json, ['error' => $e]);
        }

        echo json_encode($json);
    }

    public function updateIblockElement($req)
    {
        global $USER;

        $el = new \CIBlockElement;

        $userID = $USER->GetID();

        if(CLIENT_MODE === "DEVELOPMENT")
        {
            $userID = 1;
        }

        $values = json_decode($req['values'], JSON_OBJECT_AS_ARRAY);

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $userID, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $req['idSection'],          // элемент лежит в корне раздела
            "NAME"           => $values['NAME'],
//            "ACTIVE"         => "Y",            // активен
//            "PREVIEW_TEXT"   => "текст для списка элементов",
            "DETAIL_TEXT"    => $values['DETAIL_TEXT'],
//            "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
        );


        $res = $el->Update($req['idElement'], $arLoadProductArray);

        if(!$res)
        {
            self::$status = 500;
        }


        echo json_encode([
            'status'     => self::$status,
            'res'        => $res,
        ]);
    }

    public function addIblockElement($req)
    {
        global $USER;

        $el = new \CIBlockElement;

        $userID = $USER->GetID();

        if(CLIENT_MODE === "DEVELOPMENT")
        {
            $userID = 1;
        }

        $values = json_decode($req['values'], JSON_OBJECT_AS_ARRAY);

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $userID, // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $req['idSection'],          // элемент лежит в корне раздела
            "IBLOCK_ID"         => $req['idIblock'],
            "NAME"           => $values['NAME'],
//            "ACTIVE"         => "Y",            // активен
//            "PREVIEW_TEXT"   => "текст для списка элементов",
            "DETAIL_TEXT"    => $values['DETAIL_TEXT'],
//            "DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
        );

        $res   = $el->Add($arLoadProductArray);

        $error = !$res ? $el->LAST_ERROR : '';

        echo json_encode([
            'status'     => self::$status,
            'res'        => $res,
            'error'      => $error
        ]);
    }

    public function updateIblockSection($req)
    {
        global $USER;

        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];

        $bs = new \CIBlockSection;

        $userID = $USER->GetID();

        if(CLIENT_MODE === "DEVELOPMENT")
        {
            $userID = 1;
        }

        $values = json_decode($req['values'], JSON_OBJECT_AS_ARRAY);

        $arFields = Array(
//            "ACTIVE" => $ACTIVE,
            "IBLOCK_ID"         => $req['idIblock'],
            "IBLOCK_SECTION_ID" => $values['IBLOCK_SECTION_ID'],
            "NAME"              => $values['NAME'],
//            "SORT" => $SORT,
//            "PICTURE" => $arPICTURE,
//            "DESCRIPTION" => $DESCRIPTION,
//            "DESCRIPTION_TYPE" => $DESCRIPTION_TYPE
        );

        try
        {
            $res = $bs->Update($req['idSection'], $arFields);

            $error = !$res ? $bs->LAST_ERROR : '';

            $json['res']   = $res;
            $json['error'] = $error;
        }
        catch (Exception $e)
        {
            self::$status = 500;
            $json = array_merge($json, ['error' => $e]);
        }

        echo json_encode($json);
    }

    public function addIblockSection($req)
    {
        global $USER;

        $json = [
            'status'  => self::$status,
            'res'    => null,
        ];

        $bs = new \CIBlockSection;

        $userID = $USER->GetID();

        if(CLIENT_MODE === "DEVELOPMENT")
        {
            $userID = 1;
        }

        $values = json_decode($req['values'], JSON_OBJECT_AS_ARRAY);

        $arFields = Array(
//            "ACTIVE" => $ACTIVE,
            "IBLOCK_ID"         => $req['idIblock'],
            "IBLOCK_SECTION_ID" => $values['IBLOCK_SECTION_ID'],
            "NAME"              => $values['NAME'],
//            "SORT" => $SORT,
//            "PICTURE" => $arPICTURE,
//            "DESCRIPTION" => $DESCRIPTION,
//            "DESCRIPTION_TYPE" => $DESCRIPTION_TYPE
        );

        try
        {
            $res = $bs->Add($arFields);

            $error = !$res ? $bs->LAST_ERROR : '';

            $json['res']   = $res;
            $json['error'] = $error;
        }
        catch (Exception $e)
        {
            self::$status = 500;
            $json = array_merge($json, ['error' => $e]);
        }

        echo json_encode($json);
    }
}

$c = new IBlock();

switch ($_REQUEST['q'])
{
    case "getListIblock":
        $c->getListIblock();
    break;
    case "getListIblockSection":
        $c->getListIblockSection($_REQUEST['id']);
    break;
    case "getListIblockElement":
        $c->getListIblockElement($_REQUEST['id'], $_REQUEST['idsection'], $_REQUEST['nPageSize']);
    break;
    case "getIblockElement":
        $c->getIblockElement($_REQUEST['id'], $_REQUEST['idElement']);
    break;
    case "getIblockSection":
        $c->getIblockSection($_REQUEST['idsection']);
    break;
    case "updateIblockElement":
        $c->updateIblockElement($_REQUEST);
    break;
    case "addIblockElement":
        $c->addIblockElement($_REQUEST);
    break;
    case "updateIblockSection":
        $c->updateIblockSection($_REQUEST);
    break;
    case "addIblockSection":
        $c->addIblockSection($_REQUEST);
    break;
}
