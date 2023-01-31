<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php echo get_bloginfo('name'); ?> - <?php the_title(); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#fafafa">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-barba="wrapper">
<?php wp_body_open(); ?>
    <main data-barba="container">