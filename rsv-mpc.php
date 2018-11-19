<?php
/*
  Plugin Name: RSV Multiple Page Creator
  Plugin URI: http://www.rapidsort.in
  Description: RSV Multiple Page Creator
  Version: 1.0
  Author: Rapid Sort
  Author URI: http://www.rapidsort.in
*/
defined( 'ABSPATH' ) or die('No script kiddies please!');
global $wp_version;
if( version_compare( $wp_version, "2.9", "<" )){
    exit( 'This plugin requires WordPress 2.9 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>' );
}

// Add callback to admin menu
add_action('admin_menu', 'rsv_mpc_create_menu');
// Callback to add menu items
function rsv_mpc_create_menu() {
	add_menu_page('RSV MPC', 'RSV MPC', 'manage_options', 'rsv-mpc', 'wp_rsv_mpc_fnc' ,'dashicons-media-text',21);
}
function wp_rsv_mpc_fnc() {
    if( sanitize_text_field($_POST['rsv_mpc_textarea_data'])!="" ) {		
$text = trim($_POST['rsv_mpc_textarea_data']);
$textAr = explode("\n", $text);
$textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
foreach ($textAr as $line) {
   // processing here. 
        global $user_ID;
        $new_post = array(
            'post_title' => $line,
            'post_content' => 'Some text',
            'post_status' => 'publish',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $user_ID,
            'post_type' => 'page',
        );
        $post_id = wp_insert_post($new_post);
        if( !$post_id ){
			  wp_die('Error creating template page');
		}else{

		}	
    }   
				?>

<div class="updated">
  <p>
    <?php _e( count($textAr).' Pages Created..!', 'my-text-domain' ); ?>
  </p>
</div>
<?php
	
}
?>
<h2>Create Multiple Pages</h2>
<p>1) Add text as multiple lines in textarea and click on Create Pages Button.<br />
  2) RSV MPC will take each line as new page and it will create pages according to your text. </p>
<form name="frm_main" action="" method="POSt">
  <textarea class="widefat" type="text" name="rsv_mpc_textarea_data" style="width:98%;" rows="10" required="required"></textarea>
  <br />
  <br />
  <input class="button button-primary" type="submit" value="Create Pages" name="btn_submit" />
</form>
<?php
}
?>