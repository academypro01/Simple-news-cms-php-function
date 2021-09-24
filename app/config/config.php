<?php
// set timezone
date_default_timezone_set("Asia/Tehran");

// database information
define('DB_SERVER','localhost');
define('DB_USER'  , 'root');
define('DB_PASS'  , '');
define('DB_NAME'  , 'newscms');
define('DOMAIN_NAME'  , 'localhost');


// set cookies params
if(!isset($_SESSION)){  
    session_set_cookie_params(0, '/', DOMAIN_NAME, true, true);
    ini_set( 'session.cookie_httponly', 1 );
    @session_regenerate_id(true);  
    ob_start();  
    session_start();
    
}    


// salt
define("SALT", 'asdf654asdf+ASDF@#$@#^!@#$65+6sdf65adf@#$DFASDFmajid');