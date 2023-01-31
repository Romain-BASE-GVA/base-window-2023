<?php

// Enregistrement d'un type de contenu supplémentaire
function base_window_custom_post_types_events() {

	$labels = array(
		'name'              => 'Events',
		'singular_name'     => 'Event',
		'add_new_item'      => 'Add an Event',
		'menu_name'			=> 'Events'
	);

	$args = array(
		'public' => true,
		'show_in_rest' => true,
		'labels'  => $labels,
		'rewrite' => [
			'slug' => 'event',
			'with_front' => false
		],
		// 'with_front' => false,
		'menu_icon' => 'dashicons-star-filled',
		'supports' => array('title', 'thumbnail', 'page-attributes'),
	);

	// Ajout du CPT
	register_post_type( 'events', $args );
}
add_action( 'init', 'base_window_custom_post_types_events' );

