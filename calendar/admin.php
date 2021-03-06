<?php
include_once 'includes/init.php';

function print_color_sample ( $color ) {
  echo "<table style=\"border-width:0px;\"><tr><td style=\"background-color:$color;\">&nbsp;&nbsp;</td></tr></table>";
}


// I know we've already loaded the global settings above, but read them
// in again and store them in a different place because they may have
// been superceded by local user preferences.
// We will store value in the array $s[].
$res = dbi_query ( "SELECT cal_setting, cal_value FROM webcal_config" );
$s = array ();
if ( $res ) {
  while ( $row = dbi_fetch_row ( $res ) ) {
    $setting = $row[0];
    $value = $row[1];
    $s[$setting] = $value;
    //echo "Setting '$setting' to '$value' <br />\n";
  }
  dbi_free_result ( $res );
}

$INC = array('js/admin.php');
print_header($INC);
?>

<h2><?php etranslate("System Settings")?></h2>
<?php
$error = false;

if ( ! $is_admin ) {
  etranslate ( "You are not authorized" );
  $error = true;
}
if ( empty ( $ovrd ) && ! $error ) {
  echo "<blockquote>" . translate ( "Note" ) . ": " .
    "<a href=\"pref.php\">" .
    translate ( "Your user preferences" ) . "</a> " .
    translate ( "may be affecting the appearance of this page.") . ".  " .
    "<a href=\"admin.php?ovrd=1\">" .
    translate ( "Click here" ) . "</a> " .
    translate ( "to not use your user preferences when viewing this page" ) .
    ".</blockquote>\n";
} else if ( ! $error ) {
  echo "<blockquote>" . translate ( "Note" ) . ": " .
    "<a href=\"pref.php\">" .
    translate ( "Your user preferences" ) . "</a> " .
    translate ( "are being ignored while viewing this page.") . ".  " .
    "<a href=\"admin.php\">" .
    translate ( "Click here" ) . "</a> " .
    translate ( "to load your user preferences when viewing this page" ) .
    ".</blockquote>\n";
}


if ( ! $error ) {
?>

<form action="admin_handler.php" method="post" onsubmit="return valid_form(this);" name="prefform">
<table style="border-width:0px;"><tr><td>
<input type="submit" value="<?php etranslate("Save")?>" name="" />
<script type="text/javascript">
<!--
  document.writeln ( '<input type="button" value="<?php etranslate("Help")?>..." onclick="window.open ( \'help_admin.php\', \'cal_help\', \'dependent,menubar,scrollbars,height=400,width=400,innerHeight=420,outerWidth=420\');" />' );
-->
</script>
</td></tr></table>
<br />

<?php if ( ! empty ( $ovrd ) ) { ?>
  <input type="hidden" name="ovrd" id="ovrd" value="1" />
<?php } ?>


<h3><?php etranslate("Settings")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
	<tr><td class="tooltip">
		<label for="admin_application_name" title="<?php etooltip("app-name-help")?>"><?php etranslate("Application Name")?>:</label></td><td>
		<input type="text" size="40" name="admin_application_name" id="admin_application_name" value="<?php echo htmlspecialchars ( $application_name );?>" />
	</td></tr>
	<tr><td class="tooltip">
		<label for="admin_server_url" title="<?php etooltip("server-url-help")?>"><?php etranslate("Server URL")?>:</label></td><td>
		<input type="text" size="40" name="admin_server_url" id="admin_server_url" value="<?php echo htmlspecialchars ( $server_url );?>" />
	</td></tr>
	<tr><td class="tooltipselect">
		<label for="admin_language" title="<?php etooltip("language-help");?>"><?php etranslate("Language")?>:</label></td><td>
		<select name="admin_LANGUAGE" id="admin_language">
<?php
reset ( $languages );
while ( list ( $key, $val ) = each ( $languages ) ) {
  echo "<option value=\"" . $val . "\"";
  if ( $val == $s['LANGUAGE'] ) echo " selected=\"selected\"";
  echo ">" . $key . "</option>\n";
}
?>
		</select>
		<br />
		<?php etranslate("Your browser default language is"); echo " "; etranslate(get_browser_language()); echo "."; ?>
	</td></tr>
	<tr><td class="tooltip">
		<label for="admin_fonts" title="<?php etooltip("fonts-help") ?>"><?php etranslate("Fonts")?>:</label></td><td>
		<input type="text" size="40" name="admin_FONTS" id="admin_fonts" value="<?php echo htmlspecialchars ( $FONTS );?>" />
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("custom-script-help");?>">
		<?php etranslate("Custom script/stylesheet")?>:</td><td>
		<label><input type="radio" name="admin_CUSTOM_SCRIPT" value="Y" <?php if ( $s["CUSTOM_SCRIPT"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label>&nbsp;
		<label><input type="radio" name="admin_CUSTOM_SCRIPT" value="N" <?php if ( $s["CUSTOM_SCRIPT"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>&nbsp;&nbsp;
		<input type="button" value="<?php etranslate("Edit");?>..." onclick="window.open('edit_template.php?type=S','cal_template','dependent,menubar,scrollbars,height=500,width=500,outerHeight=520,outerWidth=520');" name="" />
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("custom-header-help");?>">
		<?php etranslate("Custom header")?>:</td><td>
		<label><input type="radio" name="admin_CUSTOM_HEADER" value="Y" <?php if ( $s["CUSTOM_HEADER"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label>&nbsp;
		<label><input type="radio" name="admin_CUSTOM_HEADER" value="N" <?php if ( $s["CUSTOM_HEADER"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>&nbsp;&nbsp;
		<input type="button" value="<?php etranslate("Edit");?>..." onclick="window.open('edit_template.php?type=H','cal_template','dependent,menubar,scrollbars,height=500,width=500,outerHeight=520,outerWidth=520');" name="" />
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("custom-trailer-help");?>">
		<?php etranslate("Custom trailer")?>:</td><td>
		<label><input type="radio" name="admin_CUSTOM_TRAILER" value="Y" <?php if ( $s["CUSTOM_TRAILER"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label>&nbsp;
		<label><input type="radio" name="admin_CUSTOM_TRAILER" value="N" <?php if ( $s["CUSTOM_TRAILER"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>&nbsp;&nbsp;
		<input type="button" value="<?php etranslate("Edit");?>..." onclick="window.open('edit_template.php?type=T','cal_template','dependent,menubar,scrollbars,height=500,width=500,outerHeight=520,outerWidth=520');" name="" />
	</td></tr>
	<tr><td class="tooltip">
		<label for="admin_startview" title="<?php etooltip("preferred-view-help");?>"><?php etranslate("Preferred view")?>:</label></td><td>
		<select name="admin_STARTVIEW" id="admin_startview">
			<option value="day" <?php if ( $s["STARTVIEW"] == "day" ) echo " selected=\"selected\"";?>><?php etranslate("Day")?></option>
			<option value="week" <?php if ( $s["STARTVIEW"] == "week" ) echo " selected=\"selected\"";?>><?php etranslate("Week")?></option>
			<option value="month" <?php if ( $s["STARTVIEW"] == "month" ) echo " selected=\"selected\"";?>><?php etranslate("Month")?></option>
			<option value="year" <?php if ( $s["STARTVIEW"] == "year" ) echo " selected=\"selected\"";?>><?php etranslate("Year")?></option>
		</select>
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("display-weekends-help");?>">
		<?php etranslate("Display weekends in week view")?>:</td><td>
		<label><input type="radio" name="admin_DISPLAY_WEEKENDS" value="Y" <?php if ( $s["DISPLAY_WEEKENDS"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_DISPLAY_WEEKENDS" value="N" <?php if ( $s["DISPLAY_WEEKENDS"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("yearly-shows-events-help");?>">
		<?php etranslate("Display days with events in bold in year view")?>:</td><td>
		<label><input type="radio" name="admin_bold_days_in_year" value="Y" <?php if ( $s["bold_days_in_year"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_bold_days_in_year" value="N" <?php if ( $s["bold_days_in_year"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>
	</td></tr>
	<tr><td class="tooltip" title="<?php etooltip("display-desc-print-day-help");?>">
		<?php etranslate("Display description in printer day view")?>:</td><td>
		<label><input type="radio" name="admin_DISPLAY_DESC_PRINT_DAY" value="Y" <?php if ( $s["DISPLAY_DESC_PRINT_DAY"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_DISPLAY_DESC_PRINT_DAY" value="N" <?php if ( $s["DISPLAY_DESC_PRINT_DAY"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label>
	</td></tr>
	<tr><td class="tooltipselect" title="<?php etooltip("date-format-help");?>">
		<?php etranslate("Date format")?>:</td><td>
		<select name="admin_DATE_FORMAT">
  <?php
  // You can add new date formats below if you want.
  // but also add in pref.php.
  $datestyles = array (
    "__month__ __dd__, __yyyy__", translate("December") . " 31, 2000",
    "__dd__ __month__, __yyyy__", "31 " . translate("December") . ", 2000",
    "__dd__-__month__-__yyyy__", "31-" . translate("December") . "-2000",
    "__dd__-__month__-__yy__", "31-" . translate("December") . "-00",
    "__mm__/__dd__/__yyyy__", "12/31/2000",
    "__mm__/__dd__/__yy__", "12/31/00",
    "__mm__-__dd__-__yyyy__", "12-31-2000",
    "__mm__-__dd__-__yy__", "12-31-00",
    "__yyyy__-__mm__-__dd__", "2000-12-31",
    "__yy__-__mm__-__dd__", "00-12-31",
    "__yyyy__/__mm__/__dd__", "2000/12/31",
    "__yy__/__mm__/__dd__", "00/12/31",
    "__dd__/__mm__/__yyyy__", "31/12/2000",
    "__dd__/__mm__/__yy__", "31/12/00",
    "__dd__-__mm__-__yyyy__", "31-12-2000",
    "__dd__-__mm__-__yy__", "31-12-00"
  );
  for ( $i = 0; $i < count ( $datestyles ); $i += 2 ) {
    echo "<option value=\"" . $datestyles[$i] . "\"";
    if ( $s["DATE_FORMAT"] == $datestyles[$i] )
      echo " selected=\"selected\"";
    echo ">" . $datestyles[$i + 1] . "</option>\n";
  }
  ?>
</select>
<br />
  <select name="admin_DATE_FORMAT_MY">
  <?php
  // Date format for a month and year (with no day of the month)
  // You can add new date formats below if you want.
  // but also add in admin.php.
  $datestyles = array (
    "__month__ __yyyy__", translate("December") . " 2000",
    "__month__ __yy__", translate("December") . " 00",
    "__month__-__yyyy__", translate("December") . "-2000",
    "__month__-__yy__", translate("December") . "-00",
    "__mm__/__yyyy__", "12/2000",
    "__mm__/__yy__", "12/00",
    "__mm__-__yyyy__", "12-2000",
    "__mm__-__yy__", "12-00",
    "__yyyy__-__mm__", "2000-12",
    "__yy__-__mm__", "00-12",
    "__yyyy__/__mm__", "2000/12",
    "__yy__/__mm__", "00/12"
  );
  for ( $i = 0; $i < count ( $datestyles ); $i += 2 ) {
    echo "<option value=\"" . $datestyles[$i] . "\"";
    if ( $s["DATE_FORMAT_MY"] == $datestyles[$i] )
      echo " selected=\"selected\"";
    echo ">" . $datestyles[$i + 1] . "</option>\n";
  }
  ?>
</select>
  <br />
  <select name="admin_DATE_FORMAT_MD">
  <?php
  // Date format for a month and day (with no year displayed)
  // You can add new date formats below if you want.
  // but also add in admin.php.
  $datestyles = array (
    "__month__ __dd__", translate("December") . " 31",
    "__month__-__dd__", translate("December") . "-31",
    "__mm__/__dd__", "12/31",
    "__mm__-__dd__", "12-31",
    "__dd__/__mm__", "31/12",
    "__dd__-__mm__", "31-12"
  );
  for ( $i = 0; $i < count ( $datestyles ); $i += 2 ) {
    echo "<option value=\"" . $datestyles[$i] . "\"";
    if ( $s["DATE_FORMAT_MD"] == $datestyles[$i] )
      echo " selected=\"selected\"";
    echo ">" . $datestyles[$i + 1] . "</option>\n";
  }
  ?>
  </select>
</td></tr>

<tr><td class="tooltip" title="<?php etooltip("time-format-help")?>"><?php etranslate("Time format")?>:</td><td>
<label><input type="radio" name="admin_TIME_FORMAT" value="12" <?php if ( $s["TIME_FORMAT"] == "12" ) echo " checked=\"checked\"";?> /> <?php etranslate("12 hour")?></label> <label><input type="radio" name="admin_TIME_FORMAT" value="24" <?php if ( $s["TIME_FORMAT"] != "12" ) echo " checked=\"checked\"";?> /> <?php etranslate("24 hour")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("time-interval-help")?>"><?php etranslate("Time interval")?>:</td><td>
	<select name="admin_TIME_SLOTS">
  <option value="24" <?php if ( $s["TIME_SLOTS"] == "24" ) echo " selected=\"selected\""?>>1 <?php etranslate("hour")?></option>
  <option value="48" <?php if ( $s["TIME_SLOTS"] == "48" ) echo " selected=\"selected\""?>>30 <?php etranslate("minutes")?></option>
  <option value="72" <?php if ( $s["TIME_SLOTS"] == "72" ) echo " selected=\"selected\""?>>20 <?php etranslate("minutes")?></option>
  <option value="144" <?php if ( $s["TIME_SLOTS"] == "144" ) echo " selected=\"selected\""?>>10 <?php etranslate("minutes")?></option>
  </select>
</td></tr>

<tr><td class="tooltip" title="<?php etooltip("auto-refresh-help");?>"><?php etranslate("Auto-refresh calendars")?>:</td><td>
<label><input type="radio" name="admin_auto_refresh" value="Y" <?php if ( $s["auto_refresh"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_auto_refresh" value="N" <?php if ( $s["auto_refresh"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("auto-refresh-time-help");?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Auto-refresh time")?>:</td><td>
<input type="text" name="admin_auto_refresh_time" size="4" value="<?php if ( empty ( $s["auto_refresh_time"] ) ) echo "0"; else echo $s["auto_refresh_time"]; ?>" /> <?php etranslate("minutes")?></td></tr>

<tr><td class="tooltip" title="<?php etooltip("require-approvals-help");?>"><?php etranslate("Require event approvals")?>:</td><td>
<label><input type="radio" name="admin_require_approvals" value="Y" <?php if ( $s["require_approvals"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_require_approvals" value="N" <?php if ( $s["require_approvals"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("display-unapproved-help");?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Display unapproved")?>:</td><td>
<label><input type="radio" name="admin_DISPLAY_UNAPPROVED" value="Y" <?php if ( $s["DISPLAY_UNAPPROVED"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_DISPLAY_UNAPPROVED" value="N" <?php if ( $s["DISPLAY_UNAPPROVED"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("display-week-number-help")?>"><?php etranslate("Display week number")?>:</td><td>
<label><input type="radio" name="admin_DISPLAY_WEEKNUMBER" value="Y" <?php if ( $s["DISPLAY_WEEKNUMBER"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_DISPLAY_WEEKNUMBER" value="N" <?php if ( $s["DISPLAY_WEEKNUMBER"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("display-week-starts-on")?>"><?php etranslate("Week starts on")?>:</td><td>
<label><input type="radio" name="admin_WEEK_START" value="0" <?php if ( $s["WEEK_START"] != "1" ) echo " checked=\"checked\"";?> /> <?php etranslate("Sunday")?></label> <label><input type="radio" name="admin_WEEK_START" value="1" <?php if ( $s["WEEK_START"] == "1" ) echo " checked=\"checked\"";?> /> <?php etranslate("Monday")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("work-hours-help")?>"><?php etranslate("Work hours")?>:</td><td>
  <?php etranslate("From")?> <select name="admin_WORK_DAY_START_HOUR">
  <?php
  for ( $i = 0; $i < 24; $i++ ) {
    echo "<option value=\"$i\" " .
      ( $i == $s["WORK_DAY_START_HOUR"] ? " selected=\"selected\"" : "" ) .
      ">" . display_time ( $i * 10000 ) . "</option>\n";
  }
  ?>
  </select> <?php etranslate("to")?>
  <select name="admin_WORK_DAY_END_HOUR">
  <?php
  for ( $i = 0; $i < 24; $i++ ) {
    echo "<option value=\"$i\" " .
      ( $i == $s["WORK_DAY_END_HOUR"] ? " selected=\"selected\"" : "" ) .
      ">" . display_time ( $i * 10000 ) . "</option>\n";
  }
  ?>
  </select>
  </td></tr>

<tr><td class="tooltip" title="<?php etooltip("disable-priority-field-help")?>"><?php etranslate("Disable Priority field")?>:</td>
  <td><label><input type="radio" name="admin_disable_priority_field" value="Y" <?php if ( $s["disable_priority_field"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_disable_priority_field" value="N" <?php if ( $s["disable_priority_field"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("disable-access-field-help")?>"><?php etranslate("Disable Access field")?>:</td>
  <td><label><input type="radio" name="admin_disable_access_field" value="Y" <?php if ( $s["disable_access_field"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_disable_access_field" value="N" <?php if ( $s["disable_access_field"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("disable-participants-field-help")?>"><?php etranslate("Disable Participants field")?>:</td>
  <td><label><input type="radio" name="admin_disable_participants_field" value="Y" <?php if ( $s["disable_participants_field"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_disable_participants_field" value="N" <?php if ( $s["disable_participants_field"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("disable-repeating-field-help")?>"><?php etranslate("Disable Repeating field")?>:</td>
  <td><label><input type="radio" name="admin_disable_repeating_field" value="Y" <?php if ( $s["disable_repeating_field"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_disable_repeating_field" value="N" <?php if ( $s["disable_repeating_field"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("popup-includes-siteextras-help")?>"><?php etranslate("Display Site Extras in popup")?>:</td>
  <td><label><input type="radio" name="admin_site_extras_in_popup" value="Y" <?php if ( $s["site_extras_in_popup"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_site_extras_in_popup" value="N" <?php if ( $s["site_extras_in_popup"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("allow-html-description-help")?>"><?php etranslate("Allow HTML in Description")?>:</td>
  <td><label><input type="radio" name="admin_allow_html_description" value="Y" <?php if ( $s["allow_html_description"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_html_description" value="N" <?php if ( $s["allow_html_description"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("allow-view-other-help")?>"><?php etranslate("Allow viewing other user's calendars")?>:</td>
  <td><label><input type="radio" name="admin_allow_view_other" value="Y" <?php if ( $s["allow_view_other"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_view_other" value="N" <?php if ( $s["allow_view_other"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("allow-public-access-help")?>"><?php etranslate("Allow public access")?>:</td>
  <td><label><input type="radio" name="admin_public_access" value="Y" <?php if ( $s["public_access"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access" value="N" <?php if ( $s["public_access"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("public-access-default-visible")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Public access visible by default")?>:</td>
  <td><label><input type="radio" name="admin_public_access_default_visible" value="Y" <?php if ( $s["public_access_default_visible"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access_default_visible" value="N" <?php if ( $s["public_access_default_visible"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("public-access-view-others-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Public access can view other users")?>:</td>
  <td><label><input type="radio" name="admin_public_access_others" value="Y" <?php if ( $s["public_access_others"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access_others" value="N" <?php if ( $s["public_access_others"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("public-access-can-add-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Public access can add events")?>:</td>
  <td><label><input type="radio" name="admin_public_access_can_add" value="Y" <?php if ( $s["public_access_can_add"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access_can_add" value="N" <?php if ( $s["public_access_can_add"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("public-access-add-requires-approval-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Public access new events require approval")?>:</td>
  <td><label><input type="radio" name="admin_public_access_add_needs_approval" value="Y" <?php if ( $s["public_access_add_needs_approval"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access_add_needs_approval" value="N" <?php if ( $s["public_access_add_needs_approval"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("public-access-sees-participants-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Public access can view participants")?>:</td>
  <td><label><input type="radio" name="admin_public_access_view_part" value="Y" <?php if ( $s["public_access_view_part"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_public_access_view_part" value="N" <?php if ( $s["public_access_view_part"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("allow-view-add-help")?>"><?php etranslate("Include add event link in views")?>:</td>
  <td><label><input type="radio" name="admin_add_link_in_views" value="Y" <?php if ( $s["add_link_in_views"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_add_link_in_views" value="N" <?php if ( $s["add_link_in_views"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("allow-external-users-help")?>"><?php etranslate("Allow external users")?>:</td>
  <td><label><input type="radio" name="admin_allow_external_users" value="Y" <?php if ( $s["allow_external_users"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_external_users" value="N" <?php if ( $s["allow_external_users"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("external-can-receive-notification-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("External users can receive email notifications")?>:</td>
  <td><label><input type="radio" name="admin_external_notifications" value="Y" <?php if ( $s["external_notifications"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_external_notifications" value="N" <?php if ( $s["external_notifications"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("external-can-receive-reminder-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("External users can receive email reminders")?>:</td>
  <td><label><input type="radio" name="admin_external_reminders" value="Y" <?php if ( $s["external_reminders"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_external_reminders" value="N" <?php if ( $s["external_reminders"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("remember-last-login-help")?>"><?php etranslate("Remember last login")?>:</td>
  <td><label><input type="radio" name="admin_remember_last_login" value="Y" <?php if ( $s["remember_last_login"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_remember_last_login" value="N" <?php if ( $s["remember_last_login"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("conflict-check-help")?>"><?php etranslate("Check for event conflicts")?>:</td>
  <td><label><input type="radio" name="admin_allow_conflicts" value="N" <?php if ( $s["allow_conflicts"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_conflicts" value="Y" <?php if ( $s["allow_conflicts"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("conflict-months-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Conflict checking months")?>:</td>
  <td><input type="text" size="3" name="admin_conflict_repeat_months" value="<?php echo htmlspecialchars ( $conflict_repeat_months );?>" /></td></tr>

<tr><td class="tooltip" title="<?php etooltip("conflict-check-override-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Allow users to override conflicts")?>:</td>
  <td><label><input type="radio" name="admin_allow_conflict_override" value="Y" <?php if ( $s["allow_conflict_override"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_conflict_override" value="N" <?php if ( $s["allow_conflict_override"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("limit-appts-help")?>"><?php etranslate("Limit number of timed events per day")?>:</td>
  <td><label><input type="radio" name="admin_limit_appts" value="Y" <?php if ( $s["limit_appts"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_limit_appts" value="N" <?php if ( $s["limit_appts"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("limit-appts-number-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Maximum timed events per day")?>:</td>
  <td><input type="text" size="3" name="admin_limit_appts_number" value="<?php echo htmlspecialchars ( $limit_appts_number );?>" /></td></tr>

<tr><td class="tooltip" title="<?php etooltip("timed-evt-len-help")?>"><?php etranslate("Specify timed event length by")?>:</td>
  <td><label><input type="radio" name="admin_TIMED_EVT_LEN" value="D" <?php if ( $s["TIMED_EVT_LEN"] != "E" ) echo " checked=\"checked\"";?> /> <?php etranslate("Duration")?></label> <label><input type="radio" name="admin_TIMED_EVT_LEN" value="E" <?php if ( $s["TIMED_EVT_LEN"] == "E" ) echo " checked=\"checked\"";?> /> <?php etranslate("End Time")?></label></td></tr>
</table>

<!--
// <h3><?php etranslate("Plugins")?></h3>
// <table class="standard" cellspacing="1" cellpadding="2">
// <tr><td class="tooltip" title="<?php etooltip("plugins-enabled-help");?>"><?php etranslate("Enable Plugins")?>:</td>
//   <td><label><input type="radio" name="admin_plugins_enabled" value="Y" <?php if ( $s["plugins_enabled"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_plugins_enabled" value="N" <?php if ( $s["plugins_enabled"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

// <?php
// if ( $plugins_enabled == "Y" ) {
//   $plugins = get_plugin_list ( true );

//   for ( $i = 0; $i < count ( $plugins ); $i++ ) {
//     $val = $s[$plugins[$i] . ".plugin_status"];
//     echo "<tr><td class=\"tooltip\" title=\"" .
//       tooltip("plugins-sort-key-help") . "\">&nbsp;&nbsp;&nbsp;" .
//       translate("Plugin") . " " . $plugins[$i] . ":</td>\n";
//     echo "<td><input type=\"radio\" name=\"admin_" .
//        $plugins[$i] . "_plugin_status\" value=\"Y\" ";
//     if ( $val != "N" ) echo " checked=\"checked\"";
//     echo " /> " . translate("Yes");
//     echo "<input type=\"radio\" name=\"admin_" .
//        $plugins[$i] . "_plugin_status\" VALUE=\"N\" ";
//     if ( $val == "N" ) echo " checked=\"checked\"";
//     echo " /> " . translate("No") . "</td></tr>\n";
//   }
// }
// ?>
//</table>
-->


<h3><?php etranslate("Groups")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("groups-enabled-help")?>"><?php etranslate("Groups enabled")?>:</td>
  <td><label><input type="radio" name="admin_groups_enabled" value="Y" <?php if ( $s["groups_enabled"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_groups_enabled" value="N" <?php if ( $s["groups_enabled"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("user-sees-his-group-help")?>"><?php etranslate("User sees only his groups")?>:</td>
  <td><label><input type="radio" name="admin_user_sees_only_his_groups" value="Y" <?php if ( $s["user_sees_only_his_groups"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_user_sees_only_his_groups" value="N" <?php if ( $s["user_sees_only_his_groups"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
</table>


<h3><?php etranslate("Categories")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("categories-enabled-help")?>"><?php etranslate("Categories enabled")?>:</td>
  <td><label><input type="radio" name="admin_categories_enabled" value="Y" <?php if ( $s["categories_enabled"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_categories_enabled" value="N" <?php if ( $s["categories_enabled"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
</table>



<h3><?php etranslate("Nonuser")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("nonuser-enabled-help")?>"><?php etranslate("Nonuser enabled")?>:</td>
  <td><label><input type="radio" name="admin_nonuser_enabled" value="Y" <?php if ( $s["nonuser_enabled"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_nonuser_enabled" value="N" <?php if ( $s["nonuser_enabled"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("nonuser-list-help")?>"><?php etranslate("Nonuser list")?>:</td>
  <td><label><input type="radio" name="admin_nonuser_at_top" value="Y" <?php if ( $s["nonuser_at_top"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Top")?></label> <label><input type="radio" name="admin_nonuser_at_top" value="N" <?php if ( $s["nonuser_at_top"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Bottom")?></label></td></tr>
</table>


<h3><?php etranslate("Reports")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("reports-enabled-help")?>"><?php etranslate("Reports enabled")?>:</td>
  <td><label><input type="radio" name="admin_reports_enabled" value="Y" <?php if ( $s["reports_enabled"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_reports_enabled" value="N" <?php if ( $s["reports_enabled"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
</table>

<h3><?php etranslate("Subscribe/Publish")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("subscriptions-enabled-help")?>"><?php etranslate("Allow remote subscriptions")?>:</td>
  <td><label><input type="radio" name="admin_PUBLISH_ENABLED" value="Y" <?php if ( $s["PUBLISH_ENABLED"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_PUBLISH_ENABLED" value="N" <?php if ( $s["PUBLISH_ENABLED"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
</table>


<h3><?php etranslate("Email")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td class="tooltip" title="<?php etooltip("email-enabled-help")?>"><?php etranslate("Email enabled")?>:</td>
  <td><label><input type="radio" name="admin_send_email" value="Y" <?php if ( $s["send_email"] == "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_send_email" value="N" <?php if ( $s["send_email"] != "Y" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
<tr><td class="tooltip" title="<?php etooltip("email-default-sender")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Default sender address")?>:</td>
  <td><input type="text" size="30" name="admin_email_fallback_from" value="<?php echo htmlspecialchars ($email_fallback_from );?>" /></td></tr>
<tr><td colspan="2" style="font-weight:bold;"><?php etranslate("Default user settings")?>:</td></tr>
<tr><td class="tooltip" title="<?php etooltip("email-event-reminders-help")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Event reminders")?>:</td>
  <td><label><input type="radio" name="admin_EMAIL_REMINDER" value="Y" <?php if ( $s["EMAIL_REMINDER"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_EMAIL_REMINDER" value="N" <?php if ( $s["EMAIL_REMINDER"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("email-event-added")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Events added to my calendar")?>:</td>
  <td><label><input type="radio" name="admin_EMAIL_EVENT_ADDED" value="Y" <?php if ( $s["EMAIL_EVENT_ADDED"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_EMAIL_EVENT_ADDED" value="N" <?php if ( $s["EMAIL_EVENT_ADDED"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("email-event-updated")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Events updated on my calendar")?>:</td>
  <td><label><input type="radio" name="admin_EMAIL_EVENT_UPDATED" value="Y" <?php if ( $s["EMAIL_EVENT_UPDATED"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_EMAIL_EVENT_UPDATED" value="N" <?php if ( $s["EMAIL_EVENT_UPDATED"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("email-event-deleted");?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Events removed from my calendar")?>:</td>
  <td><label><input type="radio" name="admin_EMAIL_EVENT_DELETED" value="Y" <?php if ( $s["EMAIL_EVENT_DELETED"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_EMAIL_EVENT_DELETED" value="N" <?php if ( $s["EMAIL_EVENT_DELETED"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td class="tooltip" title="<?php etooltip("email-event-rejected")?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php etranslate("Event rejected by participant")?>:</td>
  <td><label><input type="radio" name="admin_EMAIL_EVENT_REJECTED" value="Y" <?php if ( $s["EMAIL_EVENT_REJECTED"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_EMAIL_EVENT_REJECTED" value="N" <?php if ( $s["EMAIL_EVENT_REJECTED"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>
</table>


<h3 class="tooltip" title="<?php etooltip("colors-help")?>"><?php etranslate("Colors")?></h3>
<table class="standard" cellspacing="1" cellpadding="2">
<tr><td style="font-weight:bold;"><?php etranslate("Allow user to customize colors")?>:</td>
  <td colspan="3"><label><input type="radio" name="admin_allow_color_customization" value="Y" <?php if ( $s["allow_color_customization"] != "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("Yes")?></label> <label><input type="radio" name="admin_allow_color_customization" value="N" <?php if ( $s["allow_color_customization"] == "N" ) echo " checked=\"checked\"";?> /> <?php etranslate("No")?></label></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Document background")?>:</td>
  <td><input type="text" name="admin_BGCOLOR" size="8" maxlength="7" value="<?php echo $s["BGCOLOR"]; ?>" /></td><td style="background-color:<?php echo $s["BGCOLOR"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_BGCOLOR')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Document title")?>:</td>
  <td><input type="text" name="admin_H2COLOR" size="8" maxlength="7" value="<?php echo $s["H2COLOR"]; ?>" /> </td><td style="background-color:<?php echo $s["H2COLOR"]?>;;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_H2COLOR')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Document text")?>:</td>
  <td><input type="text" name="admin_TEXTCOLOR" size="8" maxlength="7" value="<?php echo $s["TEXTCOLOR"]; ?>" /></td><td style="background-color:<?php echo $s["TEXTCOLOR"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_TEXTCOLOR')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Table grid color")?>:</td>
  <td><input type="text" name="admin_TABLEBG" size="8" maxlength="7" value="<?php echo $s["TABLEBG"]; ?>" /> </td><td style="background-color:<?php echo $s["TABLEBG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_TABLEBG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Table header background")?>:</td>
  <td><input type="text" name="admin_THBG" size="8" maxlength="7" value="<?php echo $s["THBG"]; ?>" /></td><td style="background-color:<?php echo $s["THBG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_THBG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

	<tr><td style="font-weight:bold;"><?php etranslate("Table header text")?>:</td>
	  <td><input type="text" name="admin_THFG" size="8" maxlength="7" value="<?php echo $s["THFG"]; ?>" /></td><td style="background-color:<?php echo $s["THFG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_THFG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

	<tr><td style="font-weight:bold;"><?php etranslate("Table cell background")?>:</td>
	  <td><input type="text" name="admin_CELLBG" size="8" maxlength="7" value="<?php echo $s["CELLBG"]; ?>" /></td><td style="background-color:<?php echo $s["CELLBG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_CELLBG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

	<tr><td style="font-weight:bold;"><?php etranslate("Table cell background for current day")?>:</td>
	  <td><input type="text" name="admin_TODAYCELLBG" size="8" maxlength="7" value="<?php echo $s["TODAYCELLBG"]; ?>" /></td><td style="background-color:<?php echo $s["TODAYCELLBG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_TODAYCELLBG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

	<tr><td style="font-weight:bold;"><?php etranslate("Table cell background for weekends")?>:</td>
	  <td><input type="text" name="admin_WEEKENDBG" size="8" maxlength="7" value="<?php echo $s["WEEKENDBG"]; ?>" /></td><td style="background-color:<?php echo $s["WEEKENDBG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_WEEKENDBG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

	<tr><td style="font-weight:bold;"><?php etranslate("Event popup background")?>:</td>
	  <td><input type="text" name="admin_POPUP_BG" size="8" maxlength="7" value="<?php echo $s["POPUP_BG"]; ?>" /></td><td style="background-color:<?php echo $s["POPUP_BG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_POPUP_BG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>

<tr><td style="font-weight:bold;"><?php etranslate("Event popup text")?>:</td>
  <td><input type="text" name="admin_POPUP_FG" size="8" maxlength="7" value="<?php echo $s["POPUP_FG"]; ?>" /></td><td style="background-color:<?php echo $s["POPUP_FG"]?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type="button" onclick="selectColor('admin_POPUP_FG')" value="<?php etranslate("Select")?>..." name="" /></td></tr>
</table>

<br /><br />
<table style="border-width:0px;"><tr><td>
<input type="submit" value="<?php etranslate("Save")?>" name="" />
<script type="text/javascript">
<!-- <![CDATA[
  document.writeln ( '<input type="button" value="<?php etranslate("Help")?>..." onclick="window.open ( \'help_admin.php\', \'cal_help\', \'dependent,menubar,scrollbars,height=400,width=400,innerHeight=420,outerWidth=420\');" />' );
//]]> -->
</script>
</td></tr></table>
</form>

<?php } // if $error ?>

<?php print_trailer (); ?>
</body>
</html>