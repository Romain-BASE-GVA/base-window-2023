<?php
// Add Shortcode
function uppercaseFn( $atts , $content = null ) {

	return '<span class="uppercase">' . $content . '</span>';

}
add_shortcode( 'uppercase', 'uppercaseFn' );
