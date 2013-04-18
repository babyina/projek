<?php
require("include/phpmailer/class.phpmailer.php");

class MyMailer extends PHPMailer {
    // Set default variables for all new objects
    var $From     = "jamlee.yanggitom@treasury.gov.my";
    var $FromName = "Rizal";
    var $Host     = "zmproxy1.treasury.gov.my";
    var $Mailer   = "smtp";                         // Alternative to IsSMTP()
    var $WordWrap = 75;

    // Replace the default error_handler
    function error_handler($msg) {
        print("My Site Error");
        print("Description:");
        printf("%s", $msg);
        exit;
    }

    // Create an additional function
    function do_something($something) {
        // Place your new code here
    }
}
?>