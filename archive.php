<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mapa_Federal
 */

get_header();

?>

<section class="centres-container">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			echo map_sff_print_entry( $post );
		}
	}

	?>

</section>


<div id="pagination-container">
<?php
the_posts_pagination(
	array(
		'prev_text' => 'Pág. anterior',
		'next_text' => 'Pág. siguiente'
		)
	);
?>

</div>
<?php
get_footer();
