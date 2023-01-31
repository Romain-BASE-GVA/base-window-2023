<?php get_header(); ?>
<?php 
	$currentEventID = get_field('current_exhibition', 'options');
	get_template_part( 'template-parts/slider', null, array('eventID' => $currentEventID) );

?>
<?php get_footer(); ?>