<?php get_header(); ?>
<?php 

	$homeEventID = get_field('home_exhibition', 'options');
	get_template_part( 'template-parts/slider', null, array('eventID' => $homeEventID) );

?>
<?php get_footer(); ?>