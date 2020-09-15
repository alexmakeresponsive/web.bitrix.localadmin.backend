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
    const CSS_DIR_APP   = "/local/admin/app/_nuxt";
    const NUXT_CSS_NAME = "app.f8d201c.css";

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

                        $id = strtolower($name);

                        $r[] = [
                            'id' => $id,
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

    private function getFileById($cssList, $id)
    {
        $name = '';

        foreach ($cssList as $i => $v)
        {
            if(substr_count($v, $id))
            {
                $name = $cssList[$i];
                break;
            }
        }

//        return str_replace('.css', '', $name);

        return $name;
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

    public static function updateFile($id)
    {
        $cssDirPath    = $_SERVER["DOCUMENT_ROOT"] . self::CSS_DIR;
        $cssDirAppPath = $_SERVER["DOCUMENT_ROOT"] . self::CSS_DIR_APP;

        $cssListRaw = scandir($cssDirPath);

        $cssList = array_filter($cssListRaw, [__CLASS__, "rmDots"]);

        $name = self::getFileById($cssList, $id);

        if(empty($name))
        {
            echo json_encode([
                'status'  => 404,
                'id'  => $id,
            ]);
           return;
        }

        try
        {
            $r1 = unlink($cssDirAppPath . '/' . self::NUXT_CSS_NAME);
            $r2 = copy($cssDirPath . '/' . $name, $cssDirAppPath . '/' . self::NUXT_CSS_NAME);

            if(in_array(false, [$r1, $r2]))
            {
                self::$status = 500;
            }

        }
        catch (Exception $e)
        {
            self::$status = 500;
        }


        echo json_encode([
            'r'  => [$r1,$r2],
            'status'  => self::$status,
        ]);
    }
}

switch ($_REQUEST['q'])
{
    case "getMap":
        Style::getMap();
    break;

    case "updateFile":
        Style::updateFile($_REQUEST['id']);
    break;
}
