<?php

// There is the potential for a lot of mischief from users trying to
// access this file in ways the shouldn't.  Users may try to type in
// a URL to get around functions that are not being displayed on the
// web page to them. 

include_once 'includes/init.php';
load_user_layers ();

$error = "";
if ( ! $is_admin )
  $user = $login;

// Handle delete
if ( ( $action == "Delete" || $action == translate ("Delete") ) &&
  $formtype == "edituser" ) {
  if ( $is_admin ) {
    if ( $admin_can_delete_user ) {
      user_delete_user ( $user ); // will also delete user's events
    } else {
      $error = translate("Deleting users not supported") . ".";
    }
  } else {
    $error = translate("You are not authorized") . ".";
  }
}

// Handle update of password
else if ( $formtype == "setpassword" && strlen ( $user ) ) {
  if ( $upassword1 != $upassword2 ) {
    $error = translate("The passwords were not identical") . ".";
  } else if ( strlen ( $upassword1 ) ) {
    if ( $user_can_update_password )
      user_update_user_password ( $user, $upassword1 );
    else
      $error = translate("You are not authorized") . ".";
  } else
    $error = translate("You have not entered a password") . ".";
}

// Handle update of user info
else if ( $formtype == "edituser" ) {
  if ( strlen ( $add ) && $is_admin ) {
    if ( $upassword1 != $upassword2 ) { 
      $error = translate( "The passwords were not identical" ) . "."; 
    } else {
      user_add_user ( $user, $upassword1, $ufirstname, $ulastname,
        $uemail, $uis_admin );
    }
  } else if ( strlen ( $add ) && ! $is_admin ) {
    $error = translate("You are not authorized") . ".";
  } else {
    // Don't allow a user to change themself to an admin by setting
    // uis_admin in the URL by hand.  They must be admin beforehand.
    if ( ! $is_admin )
      $uis_admin = "N";
    user_update_user ( $user, $ufirstname, $ulastname,
      $uemail, $uis_admin );
  }
}

if ( empty ( $error ) ) {
  if ( $is_admin )
    do_redirect ( "users.php" );
  else
    do_redirect ( "edit_user.php" );
}

print_header();
?>

<h2><?php etranslate("Error")?></h2>

<blockquote>
<?php

echo $error;
//if ( $sql != "" )
//  echo "<br /><br /><span style=\"font-weight:bold;\">SQL:</span> $sql";
//?>
</blockquote>

<?php print_trailer(); ?>
</body>
</html>
