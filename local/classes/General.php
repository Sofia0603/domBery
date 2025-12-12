<?php
namespace DigitalPlans;
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;
class General {
    public static function doScript($path){
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $path;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        $out = curl_exec($curl);
        $data = $out ? $out : curl_error($curl);
        curl_close($curl);
    }

    public static function phoneFormat($phone){
        $phone = trim($phone);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $res = preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ),
            array(
                '7$2$3$4$5',
                '7$2$3$4$5',
                '7$2$3$4$5',
                '7$2$3$4$5',
                '7$2$3$4',
                '7$2$3$4',
            ),
            $phone
        );
        return $res;
        /*if (strlen($res) == 11) return $res;
        else return false;*/
    }

    public static function wordByNum($n, $titles = false) {
        $cases = array(2, 0, 1, 1, 1, 2);
        $case = ($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)];
        if ($titles) return $titles[$case];
        else return $case;
    }

    public static function autoload($end = false){
        $autoloadClass = function($class_name){
            $checkNamespace = explode('DigitalPlans\\', $class_name);
            if (count($checkNamespace) > 1) $class_name = $checkNamespace[1];
            include_once (__DIR__.'/'.$class_name.'.php');
        };
        spl_autoload_register($autoloadClass);
        if ($end) spl_autoload_unregister($autoloadClass);
    }

    public static function cache(string $cachePath, string $cacheKey, mixed $cacheTtl, callable $func, iterable $tags = []){
        $cache = Cache::createInstance();
        if (is_array($tags) && count($tags)) $taggedCache = Application::getInstance()->getTaggedCache();
        if ($cache->initCache($cacheTtl, $cacheKey, $cachePath)) {
            $vars = $cache->getVars();
            $cache->output();
        } elseif ($cache->startDataCache()) {
            if (is_array($tags) && count($tags)) $taggedCache->startTagCache($cachePath);
            $vars = $func();
            if (is_array($tags) && count($tags)) {
                foreach ($tags as $tag) $taggedCache->registerTag($tag);
                $taggedCache->endTagCache();
            }
            $cache->endDataCache($vars);
        }
        return $vars;
    }
}
?>