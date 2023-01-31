<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $eventID = $post->ID;
?>

<?php get_template_part( 'template-parts/slider', null, array('eventID' => $eventID) ); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>