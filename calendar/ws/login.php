<?php
/*
 * $Id: login.php,v 1.1 2004/06/24 02:18:30 cknudsen Exp $
 *
 * Description:
 * 	Provides login mechanism for web service clients.
 */

$basedir = "..";
$includedir = "../includes";

include "$includedir/config.php";
include "$includedir/php-dbi.php";
include "$includedir/functions.php";
include "$includedir/$user_inc";
include "$includedir/connect.php";

load_global_settings ();

if ( ! empty ( $last_login ) )
  $login = "";

include "$includedir/translate.php";

// calculate path for cookie
if ( empty ( $PHP_SELF ) )
  $PHP_SELF = $_SERVER["PHP_SELF"];
$cookie_path = str_replace ( "login.php", "", $PHP_SELF );
//echo "Cookie path: $cookie_path\n";

$out = "<login>\n";

if ( $single_user == "Y" ) {
  // No login for single-user mode
  $out .= "<error>No login required for single-user mode</error>\n";
} else if ( $use_http_auth ) {
  // There is no login page when using HTTP authorization
  $out .= "<error>No login required for HTTP authentication</error>\n";
} else {
  if ( ! empty ( $login ) && ! empty ( $password ) ) {
    $login = trim ( $login );
    if ( user_valid_login ( $login, $password ) ) {
      user_load_variables ( $login, "" );
      // set login to expire in 365 days
      srand((double) microtime() * 1000000);
      $salt = chr( rand(ord('A'), ord('z'))) . chr( rand(ord('A'), ord('z')));
      $encoded_login = encode_string ( $login . "|" . crypt($password, $salt) );
      //SetCookie ( "webcalendar_session", $encoded_login, 0, $cookie_path );
      $out .= "  <cookieName>webcalendar_session</cookieName>\n";
      $out .= "  <cookieValue>$encoded_login</cookieValue>\n";
    } else {
      $out .= "  <error>Invalid login</error>\n";
    }
  }
}

echo $out;
echo "</login>\n";
?>
