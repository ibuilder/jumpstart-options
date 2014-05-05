<?php
/*-------------------------------------------------------*/
/* Jumpstart Options - Child Theme
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* User Meta Data
/*-------------------------------------------------------*/
// ** Frontend **		
$option_name = themeblvd_get_option_name();
$options = get_option( $option_name );
// Remove Edit link
if ($options['disable_editlink'] == 'Yes') {
    add_filter( 'edit_post_link', '__return_false' );
}
/*-------------------------------------------------------*/
/* Customize Contact Methods
/* @author Bill Erickson
/* @link http://sillybean.net/2010/01/creating-a-user-directory-part-1-changing-user-contact-fields/
/*-------------------------------------------------------*/
add_filter('user_contactmethods','rebel_contactupdate',10,1);
function rebel_contactupdate ( $contactmethods, $user ) {
  unset($contactmethods['yim']); // Remove Yahoo IM
  unset($contactmethods['aim']); // Remove AIM
  unset($contactmethods['jabber']); // Remove Jabber\

  $contactmethods['phone_number'] = 'Phone Number'; // Phone Number
  $contactmethods['twitter'] = 'Twitter'; // Add Twitter
  $contactmethods['facebook'] = 'Facebook'; // Add Facebook

  $contactmethods['company'] = 'Company'; // Add Facebook

  return $contactmethods;
}
/*-------------------------------------------------------*/
/* Add Phone Number
/*-------------------------------------------------------*/
add_action( 'personal_options_update', 'rebel_profile_fields' );
add_action( 'edit_user_profile_update', 'rebel_profile_fields' );
function rebel_profile_fields( $user_id ) {
    update_user_meta( $user_id, 'phone_number', $_POST['phone_number'], get_user_meta( $user_id, 'phone_number', true ) );
    update_user_meta( $user_id, 'company', $_POST['company'], get_user_meta( $user_id, 'company', true ) );
    update_user_meta( $user_id, 'greeting', $_POST['greeting'], get_user_meta( $user_id, 'greeting', true ) );
}
/*-------------------------------------------------------*/
/* Add Profile Options
/*-------------------------------------------------------*/
add_action( 'personal_options', 'rebel_add_profile_options');
function rebel_add_profile_options( $profileuser ) {
    $greeting = get_user_meta($profileuser->ID, 'greeting', true);
    ?>
      <tr>
        <th scope="row">Greeting</th>
        <td><input type="text" name="greeting" value="<?php echo $greeting; ?>" /></td>
      </tr>
    <?php
}
/*-------------------------------------------------------*/
/* Check user Role with durrent_user_can()
/* http://wpbandit.com/code/check-a-users-role-in-wordpress/
/*-------------------------------------------------------*/
function check_user_role($roles,$user_id=NULL) {
  // Get user by ID, else get current user
  if ($user_id)
    $user = get_userdata($user_id);
  else
    $user = wp_get_current_user();
 
  // No user found, return
  if (empty($user))
    return FALSE;
 
  // Append administrator to roles, if necessary
  if (!in_array('administrator',$roles))
    $roles[] = 'administrator';
 
  // Loop through user roles
  foreach ($user->roles as $role) {
    // Does user have role
    if (in_array($role,$roles)) {
      return TRUE;
    }
  }
 
  // User not in roles
  return FALSE;
}
?>