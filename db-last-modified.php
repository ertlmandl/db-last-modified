<?php

/*
Plugin Name: Last Modified
Description: Shows date of last DB Update in Dashboard
Version:     1.0
Author:      Christoph Mandl
Author URI:  https://www.studioh8.de
*/


add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('last_modified_widget', 'Last modified', 'last_modified');
}
	 
function last_modified() {
	
  // Find the last modified post and get its ID
	
	$args = array(
	  'post_type' => 'any',
	  'posts_per_page' => 1,
	  'orderby' => 'modified',
	);
	$last_updated = new WP_Query($args);
	$modified_post_id = $last_updated->post->ID;
	
	wp_reset_postdata();
	
	// Query the last modified Post by its ID, to retrieve Post data 
	
	$new_args = array(
    'p' => $modified_post_id,
    'post_type' => 'any'
  );
	
	$modified_post = new WP_Query($new_args);
	
	if($modified_post->have_posts()) : 
    while ( $modified_post->have_posts() ) : $modified_post->the_post();
    	
    	$modified_post_title = get_the_title();
			$modified_post_url = get_the_permalink();
			$modified_date = get_the_modified_date('d.m.Y');
			$modified_time = get_the_modified_date('H:i:s');
    	$modified_user = get_the_modified_author();
    	
    	if ( date('d.m.Y') == $modified_date ) {
	    	$modified_date = 'Heute';
    	}
    
    endwhile; 
	endif;
	
	wp_reset_postdata();
	
	// Output to dashboard  
	
	echo '<p>Letzte Änderung: ' . $modified_date . ' um ' . $modified_time . '</p>';
	echo '<p>Geändert wurde: <a href="' . $modified_post_url . '">' . $modified_post_title . '</a></p>';
	echo '<p>Geändert von: ' . $modified_user . '</p>';
}


?>