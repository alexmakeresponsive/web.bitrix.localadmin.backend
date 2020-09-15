<?php
/**
 * @var $userId;
 * @var $userGroupIdList;
 * */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");

class Style
{
    const CSS_DIR       = "/local/admin/asset/_nuxt/css";
    const NUXT_CSS_NAME = "app.0c41111.css";

    private static $status = 200;

    private function addTitle($cssList)
    {
        $r = [];

        $path = $_SERVER["DOCUMENT_ROOT"] . self::CSS_DIR;

        foreach ($cssList as $v)
        {
            $handle = fopen($path ."/" . $v, "r");
            $lineNumber = 1;

            if ($handle) {
                while (($line = fgets($handle)) !== false) {

                    if ($lineNumber === 4)
                    {
                        $p1 = strpos($line, "(");
                        $p2 = strpos($line, ":");

                        $name = trim(substr($line, $p2 + 1, -(strlen($line) -$p1)));

                        $r[] = [
                            'name' => $name,
                            'file' => $path ."/" . $v
                        ];
                        break;
                    }

                    $lineNumber++;
                }

                fclose($handle);
            } else {
                self::$status = 500;
            }
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
        $cssDirPath = $_SERVER["DOCUMENT_ROOT"] . self::CSS_DIR;
        $cssListRaw = scandir($cssDirPath);


        $cssList = array_filter($cssListRaw, [__CLASS__, "rmDots"]);

        $cssMapWithTitle = self::addTitle($cssList);

        echo json_encode([
            'status'  => self::$status,
            'cssMap' => $cssMapWithTitle
        ]);
    }

}

switch ($_REQUEST['q'])
{
    case "getMap":
        Style::getMap();
    break;
}
