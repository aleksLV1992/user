<?php

namespace vendor;
use assets\AppAsset;

class Controllers
{

    /**
     * @var string Ссылка на главную страницу
     */
    private $templateDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.phtml';

    /**
     * Получения Render Шаблона
     * @param $template
     * @param array $params
     * @return string
     */
    public function render($template, $params = [])
    {
        extract($params);
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $templateDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . $template . '.phtml';
        $content = ob_get_clean();

        $script = $this->GetScript();

        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $this->templateDir;
        $html = ob_get_clean();

        return $html;

    }

    /**
     * Возвращения Html шаблона
     * @param $filename
     * @param array $params
     * @return string
     */
    protected function GetTemplate($filename, $params = [])
    {
        extract($params);
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $filename;
        $template = ob_get_clean();
        return $template;
    }

    /**
     * Подулючения необходимых скриптов
     */
    private function GetScript()
    {
        $js = AppAsset::$js;
        $css = AppAsset::$css;
        $link = DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;

        $jsList = [];

        foreach ($js as $v) {
            $jsScript = $link . 'js' . DIRECTORY_SEPARATOR . $v;
            $jsList [] = "<script src='{$jsScript}'></script>";
        }

        $cssList = [];
        foreach ($css as $v) {
            $jsStyle = $link . 'css' . DIRECTORY_SEPARATOR . $v;
            $cssList [] = "<link rel='stylesheet' href='{$jsStyle}'>";
        }

        $str = implode('', $jsList);
        $str .= implode('', $cssList);
        return $str;

    }


}