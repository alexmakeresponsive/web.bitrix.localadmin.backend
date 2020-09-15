<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");

class Lang
{
    const LANG_DIR      = "/local/admin/asset/_nuxt/lang";

    private static $status = 200;

    private function getData($langList, $query)
    {
        $r = [];

            $path = $_SERVER["DOCUMENT_ROOT"] . self::LANG_DIR;

        foreach ($langList as $i => $v)
        {

            $id = str_replace ('.json', '', $v);

            $r[$id] = [];

                $string = file_get_contents($path . "/" . $v);
            if ($string === false) {
                self::$status = 500;
            }

                $json_a = json_decode($string, true);
            if ($json_a === null) {
                self::$status = 500;
            }

            if($query === 'data')
            {
                $r[$id] = array_merge($r[$id], [
                    'data' => $json_a
                ]);
            }

                $r[$id] = array_merge($r[$id], [
                    'id'     => $id,
                    'title'  => $json_a['title'],
                    'file'   => $path . "/" . $v,
                ]);
        }

        return $r;
    }

    private function rmDots($v)
    {
        if($v == '.' || $v == '..')
        {
            return false;
        }

        return true;
    }

    public static function getMap()
    {
        $langDirPath = $_SERVER["DOCUMENT_ROOT"] . self::LANG_DIR;
        $langListRaw = scandir($langDirPath);

        $langList          = array_filter($langListRaw, [__CLASS__, "rmDots"]);
        $langListWithTitle = self::getData($langList, 'title');

        echo json_encode([
            'status'  => self::$status,
            'langHead' => $langListWithTitle
        ]);
    }

    public function getJson()
    {
        $langDirPath = $_SERVER["DOCUMENT_ROOT"] . self::LANG_DIR;
        $langListRaw = scandir($langDirPath);

        $langList          = array_filter($langListRaw, [__CLASS__, "rmDots"]);
        $langListWithTitle = self::getData($langList, 'data');

        echo json_encode([
            'status'  => self::$status,
            'langData' => $langListWithTitle
        ]);
    }

}

switch ($_REQUEST['q'])
{
    case "getMap":
        Lang::getMap();
    break;
    case "getJson":
        Lang::getJson();
    break;
}
