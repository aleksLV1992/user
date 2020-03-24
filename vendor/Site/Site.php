<?php

namespace vendor;
use vendor\BDMysql;
use assets;

class Site
{
    /**
     * @var array Конфигуратор
     */
    private static $config = [];

    /**
     * @var bool|\PDO
     */
    public static $db;

    private static $_instance = null;

    public static function GetInstance()
    {
        if (is_null(Site::$_instance)) Site::$_instance = new Site();
        return Site::$_instance;
    }


    public function __construct()
    {
        $this->LoadingConfig();
        self::$db = BDMysql::PDOInit(self::GetConfig('connectDB'));
    }

    /**
     * Получения данных из config
     * @param $index
     * @return mixed|null
     */
    public static function GetConfig($index)
    {

        if (is_array(self::$config) && array_key_exists($index, self::$config))
            return self::$config[$index];
        return null;

    }

    /**
     * Загрузка файла сonfig.json
     */
    private function LoadingConfig()
    {

        $configJson = __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.json';

        if (file_exists($configJson)) {
            $str = file_get_contents($configJson);
            self::$config = json_decode($str, true);
        }

    }

    /**
     * Возвращает JSON
     * @param $j
     * @return string
     */
    public static function GetJson($j)
    {
        return json_encode($j, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Загрузка страниц Site
     */
    public static function Loading()
    {
        $uri = ltrim($_SERVER['REQUEST_URI'], '/');
        $uriGet = stristr($uri, '?', true);
        $uri = ($uriGet) ? $uriGet : $uri;
        $result = false;
        if (empty($uri))
            $uri = self::GetConfig('main');

        try {
            $uriList = explode('/', mb_strtolower($uri));
            $modules = ucwords($uriList[0]) . "Controllers";

            if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $modules . '.php')) {

                $instance = new $modules();

                if ($instance instanceof Controllers) {
                    $class_methods = get_class_methods($instance);

                    $method = null;
                    if (empty($uriList[1]))
                        $uriList[1] = 'index';
                    if (!empty($uriList[1])) {
                        $method = 'action';
                        $m = preg_split('/[_|-]+/', mb_strtolower($uriList[1]));
                        foreach ($m as $k => $v) {
                            $m[$k] = ucwords($v);
                        }
                        $method .= implode('', $m);
                    }

                    if (array_search($method, $class_methods) !== false) {
                        $result = $instance->$method();
                    }
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }


        echo($result);
    }

}