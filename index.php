<?php
/**
 * @package   last-scheduled-post-time
 * @author    Stefan Böttcher
 *
 * @last-scheduled-post-time
 * Plugin Name: last scheduled post: show date & time
 * Description: Shows the date & time of the last scheduled post in the publish box. Also comes with a shortcode [next-scheduled-post] to show the next schedlued post in your theme.
 * Version:     1.2
 * Author:      wp-hotline.com ~ Stefan
 * Author URI:  https://wp-hotline.com
 * License: GPLv2 or later
 */


add_action( 'post_submitbox_misc_actions', 'last_scheduled_post_admin_add_button_html' );
function last_scheduled_post_admin_add_button_html(){
  global $post;
  $args = array(
    'posts_per_page' => 1,
    'post_type' => 'post',
    'post_status' => 'future'
  );
  $last_id = get_posts( $args );

  //var_dump( $last_id );
  if( !empty($last_id) ) {
    ?>
    <div>
        <hr />
        <div class="misc-pub-section misc-pub-revisions">
        	<?php echo date_i18n( 'd. M Y @ H:i', strtotime( $last_id[0]->post_date ) );  ?> <?php echo __('last scheduled post'); ?>
        </div>

    </div>
    <?php
    }
}

add_shortcode( 'next-scheduled-post', 'last_scheduled_post_shortcode' );
function last_scheduled_post_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'date' => '',
        'posts_per_page' => 1,
        'time_separator' => '-',
    ), $atts );

    $html = false;
    $time_separator = $a["time_separator"];

    $args = array(
      'posts_per_page' => $a["posts_per_page"],
      'post_status' => 'future',
      'post_type' => 'post'
    );
    $next_id = get_posts( $args );

    //var_dump( $last_id );
    if( !empty( $next_id ) ) {

      $next_id = $next_id[0];

      $html .= date_i18n( 'd. M Y '.$time_separator.' H:i', strtotime( $next_id->post_date ) );
      $html .= '<h3>'.get_the_title( $next_id->ID ).'</h3>';
    }

    return $html;
}
