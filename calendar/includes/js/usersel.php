<?php
global $form,$listid,$groups;
?>

<script type="text/javascript">
<!-- <![CDATA[
function OkButton () {
  var parentlist = window.opener.document.<?php echo $form?>.elements[<?php echo $listid?>];
  var thislist = document.forms[0].elements[0];

  var found = "";

  // select/deselect all elements
  for ( i = 0; i < parentlist.length; i++ ) {
    var state = false;
    for ( j = 0; j < thislist.length; j++ ) {
      if ( thislist.options[j].value == parentlist.options[i].value ) {
        state = thislist.options[i].selected;
        found += " " + thislist.options[j].value;
      }
    }
    parentlist.options[i].selected = state;
  }
  //alert ( "Found: " + found );
  window.close ();
}

function selectAll() {
  var list = document.forms[0].elements[0];
  var i;
  for ( i = 0; i < list.options.length; i++ ) {
    list.options[i].selected = true;
  }
}

function selectNone() {
  var list = document.forms[0].elements[0];
  var i;
  for ( i = 0; i < list.options.length; i++ ) {
    list.options[i].selected = false;
  }
}

// set the state (selected or unselected) if a single
// user in the list of users
function selectByLogin ( login, state ) {
  //alert ( "selectByLogin ( " + login + ", " + state + " )" );
  var list = document.forms[0].elements[0];
  var i;
  for ( i = 0; i < list.options.length; i++ ) {
    //alert ( "text: " + list.options[i].text );
    if ( list.options[i].value == login ) {
      list.options[i].selected = state;
      return;
    }
  }
}


function toggleGroup ( state ) {
  var list = document.forms[0].elements[4];
  var selNum = list.selectedIndex;
  <?php
  for ( $i = 0; $i < count ( $groups ); $i++ ) {
    print "\n  if ( selNum == $i ) {\n";
    $res = dbi_query ( "SELECT cal_login from webcal_group_user " .
      "WHERE cal_group_id = " . $groups[$i]["cal_group_id"] );
    if ( $res ) {
      while ( $row = dbi_fetch_row ( $res ) ) {
        print "    selectByLogin ( \"$row[0]\", state );\n";
      }
      dbi_free_result ( $res );
      print "  }\n";
    }
  }
  ?>
}

// Select users from a group
function selectGroupMembers () {
  toggleGroup ( true );
}

// De-select users from a group
function deselectGroupMembers () {
  toggleGroup ( false );
}
//]]> -->
</script>