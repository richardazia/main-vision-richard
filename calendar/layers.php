<?php
include_once 'includes/init.php';
send_no_cache_header ();

$updating_public = false;
if ( $is_admin && ! empty ( $public ) && $public_access == "Y" ) {
  $updating_public = true;
  $layer_user = "__public__";
  $u_url = "&amp;public=1";
  $ret = "ret=layers.php%3Fpublic=1";
} else {
  $layer_user = $login;
  $u_url = "";
  $ret = "ret=layers.php";
}

load_user_layers ( $layer_user, 1 );

$layers_enabled = 0;
$sql = "SELECT cal_value FROM webcal_user_pref " .
  "WHERE cal_setting = 'LAYERS_STATUS' AND cal_login = '$layer_user'";
$res = dbi_query ( $sql );
if ( $res ) {
  $row = dbi_fetch_row ( $res );
  $layers_enabled = ( $row[0] == "Y" ? 1 : 0 );
  dbi_free_result ( $res );
}

print_header();
?>

<h2>
<?php
if ( $updating_public )
  echo translate($PUBLIC_ACCESS_FULLNAME) . " ";
etranslate("Layers")?></h2>

<?php

if ( $is_admin ) {
  if ( empty ( $public ) ) {
    echo "<blockquote><a href=\"layers.php?public=1\">" .
      translate("Click here") . "</a> " . 
      translate("to modify the layers settings for the") . " " .
      translate($PUBLIC_ACCESS_FULLNAME) .
      "</blockquote>\n";
  }
}

etranslate("Layers are currently");

echo " <b>";
if ( $layers_enabled ) {
  etranslate ( "Enabled" );
} else {
  etranslate ( "Disabled" );
}
echo "</b>.<br /><br />";

if ( $layers_enabled )
  echo "<a class=\"navlinks\" href=\"layers_toggle.php?status=off$u_url&amp;$ret\">" .
    translate ("Disable Layers") . "</a>\n";
else
  echo "<a class=\"navlinks\" href=\"layers_toggle.php?status=on$u_url&amp;$ret\">" .
    translate ("Enable Layers") . "</a>\n";


?>
<br /><br />


<table style="border-width:0px;">

<?php

   for($index = 0; $index < sizeof($layers); $index++) {
      $layeruser = $layers[$index]['cal_layeruser'];
      user_load_variables ( $layeruser, "layer" );
?>
       <tr><td style="vertical-align:top; font-weight:bold;"><?php etranslate("Layer")?> <?php echo ($index+1) ?></td></tr>
       <tr><td style="vertical-align:top; font-weight:bold;"><?php etranslate("Source")?>:</td>
           <td><?php echo $layerfullname; ?></td></tr>

       <tr><td style="font-weight:bold;"><?php etranslate("Color")?>:</td>
          <td style="background-color:<?php echo $CELLBG;?>; color:<?php echo ( $layers[$index]['cal_color'] ); ?>;"><?php echo ( $layers[$index]['cal_color'] ); ?></td></tr>

       <tr><td style="font-weight:bold;"><?php etranslate("Duplicates")?>:</td>
          <td>
              <?php
              if( $layers[$index]['cal_dups'] == 'N')
                etranslate("No");
              else
                etranslate("Yes");
              ?>
          </td></tr>



       <tr><td><a href="edit_layer.php?id=<?php echo $index . $u_url; ?>"><?php echo (translate("Edit layer")) ?></a></td></tr>
       <tr><td><a href="del_layer.php?id=<?php echo $index . $u_url; ?>" onclick="return confirm('<?php etranslate("Are you sure you want to delete this layer?")?>');"><?php etranslate("Delete layer")?></a><br /></td></tr>


       <tr><td><br /></td></tr>

<?php
   }
?>

       <tr><td><a href="edit_layer.php<?php if ( $updating_public ) echo "?public=1";?>"><?php echo (translate("Add layer")); ?></a></td></tr>

</table>

<form action="#">
<script type="text/javascript">
<!-- <![CDATA[
  document.writeln ( '<input type="button" value="<?php etranslate("Help")?>..." onclick="window.open ( \'help_layers.php\', \'cal_help\', \'dependent,menubar,scrollbars,height=400,width=400,innerHeight=420,outerWidth=420\');" />' );
//]]> -->
</script>
</form>

<?php print_trailer(); ?>
</body>
</html>