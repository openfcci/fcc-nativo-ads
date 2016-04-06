<?php
/*
Plugin Name: FCC Nativo Ads
Description: Adds Nativo Ad scripts to site page headings with admin settings options to toggle on or off.
Version: 1.0
Author: FCC Digital / Ryan Veitch
Author http://forumcomm.com/
License: GPLv2
*/


/* Nativo Admin Settings
*  Adds admin settings options for Nativo ads.
*/
add_action('wp_head','hook_nativo_script', 1000);
function hook_nativo_script() {
  if ('true' == get_option('nativo-ad-script')) {
    $output='<script type="text/javascript" src="//s.ntv.io/serve/load.js" async></script>';
  	echo $output;
  }
}

/**
 * Register Settings Page
 */
add_action('admin_menu', 'nativo_ad_admin_pages');
function nativo_ad_admin_pages() {
  if ( function_exists('current_user_can') && current_user_can('manage_options') ) {
   add_options_page(
     'Nativo Ad Settings',
     'Nativo Ad Settings',
     'manage_options',
     'nativo_ad_map_settings',
     'nativo_ad_map_settings'
   );
   add_action('admin_init', 'nativo_ad_admin_init');
 }
}

/**
 * Register Trap Counts
 */
function nativo_ad_admin_init() {
    register_setting('nativo-ad-settings', 'nativo-ad-script');
    add_settings_section("section", "Section", null, "demo");
    add_settings_field("demo-radio", "Demo Radio Buttons", "demo_radio_display", "demo", "section");
    register_setting("section", "demo-radio");
}

/*************************** Dashboard Page **************************
**********************************************************************
* Create admin dashboard page.
*/

function nativo_ad_map_settings() {

  /**
   * Set default option to 'false'
   */
  $nativo = get_option('nativo-ad-script');
  	if(empty($nativo)){
      update_option( 'nativo-ad-script', 'false' );
  	}

  /**
   * Render settings page.
   */
   ?>
   <div class="wrap">
       <div class="card">
           <div class="inside">
               <form action="options.php" method="post">
                   <?php settings_fields( 'nativo-ad-settings'); ?>
                   <h3>Nativo Ad Settings</h3>
                   <div style="width:220px">
                     <table class="form-table">
                         <tr valign="top">

                             <th style="padding-top: 21px;" scope="row">Enable Nativo Ads: </th>
                             <td width="75px">
                                 <p><input type="radio" name="nativo-ad-script" value="true" <?php if ( 'true' == get_option('nativo-ad-script') ) echo 'checked="checked"'; ?>>Yes</p>
                                 <p><input type="radio" name="nativo-ad-script" value="false" <?php if ( 'false' == get_option('nativo-ad-script') ) echo 'checked="checked"'; ?>>No</p>
                             </td>
                         </tr>
                     </table>
                 </div>
                   <?php submit_button(); ?>
               </form>
           </div>
       </div>
   </div>
   <?php

 }
// End Plugin Code //
?>
