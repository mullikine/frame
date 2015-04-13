<?php
class RequestHandler {

    private static $config;
    private static $sitedef;

    public static function handleRequest($config, $sitedef) {

        self::$config = $config;
        self::$sitedef = $sitedef;

        if (isset($_GET['path']) && $_GET['path'] !== '') {
            $path = explode('|', $_GET['path']);
        } else {
            $path = array();
        }

        $handlerURL = '/' . ($path[0] or '');

        if (isset($sitedef[$handlerURL])) {
            $handlerClass = $sitedef[$handlerURL]['handler'];
        } else {
            // default handler
            $handlerClass = $sitedef['/']['handler'];
        }
        
        $request = array(
                'path' => $path,
                'config' => $config,
                'sitedef' => $sitedef
        );

        $h = new $handlerClass();
        $h->handleRequest($request);
        //$handlerClass::handleRequest($request);
    }

    public static function redirect($url = '/') {
        if ($url === '/') {
            self::redirect(self::$config['baseUrl']);
        } else if (is_array($url)) {
            $url = implode('/', $url);
            self::redirect($url);
        } else if (!TextUtils::startsWith($url, 'http://')) {
            $base = self::$config['baseUrl'];
            self::redirect($base.'/'.$url);
        } else {
            header("Location: {$url}");
            exit();
        }
    }

}
?>
