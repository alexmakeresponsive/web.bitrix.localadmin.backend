<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");

class Lang
{
    const LANG_DIR      = "/local/admin/asset/_nuxt/lang";

    private static $status = 200;

    private function addTitle($langList)
    {
        $r = [];

            $path = $_SERVER["DOCUMENT_ROOT"] . self::LANG_DIR;

        foreach ($langList as $v)
        {

                $string = file_get_contents($path . "/" . $v);
            if ($string === false) {
                self::$status = 500;
            }

                $json_a = json_decode($string, true);
            if ($json_a === null) {
                self::$status = 500;
            }

            $r[] = [
                'file'  => $path . "/" . $v,
                'data' => $json_a
            ];
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
        $langListWithTitle = self::addTitle($langList);

        echo json_encode([
            'status'  => self::$status,
            'langMap' => $langListWithTitle
        ]);
    }

}

switch ($_REQUEST['q'])
{
    case "getMap":
        Lang::getMap();
    break;
}
