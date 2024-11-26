<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Mapa_Federal
 */

get_header();
?>

<section id="main-content">
    <h1 class="page-title">
		<?php echo esc_html( str_replace(
			array( 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú' ),
			array( 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U' ),
			get_the_title()
		) ); ?>
	</h1>
    <?php
	the_post_thumbnail( 'full', array( 'class' => 'single-post-img' ) );

	$post_data = map_sff_get_full_entry( $post );
	?>
	<div class="single-post-data paragraph-content">
		<?php if ( ! empty( $post_data->description ) ) { ?>
		<p class="single-post-data-item-content"><?php echo esc_html( $post_data->description ); ?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->address ) ) { ?>
		<p class="single-post-data-item-content"><strong>Dirección: </strong><?php echo esc_html( $post_data->address );

		if ( ! empty( $post_data->city ) ) {
			echo ', ' . esc_html( $post_data->city );
		}

		if ( ! empty( $post_data->province ) ) {
			echo ', ' . esc_html( $post_data->province );
		}
		?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->phone ) ) { ?>
		<p class="single-post-data-item-content"><strong>Teléfono: </strong><?php echo esc_html( $post_data->phone ); ?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->email ) ) { ?>
		<p class="single-post-data-item-content"><strong>Email: </strong><a href="mailto:<?php echo esc_attr( $post_data->email ); ?>"><?php echo esc_html( $post_data->email ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->website ) ) { ?>
		<p class="single-post-data-item-content"><strong>Sitio web: </strong><a href="<?php echo esc_url( $post_data->website ); ?>" target="_blank"><?php echo esc_html( $post_data->website ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->facebook ) ) { ?>
		<p class="single-post-data-item-content"><strong>Facebook: </strong><a href="https://www.facebook.com/<?php echo esc_attr( $post_data->facebook ); ?>" target="_blank"><?php echo esc_html( $post_data->facebook ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->instagram ) ) { ?>
		<p class="single-post-data-item-content"><strong>Instagram: </strong><a href="https://www.instagram.com/<?php echo esc_attr( '@' === substr( $post_data->instagram, 0, 1 ) ? substr( $post_data->instagram, 1 ) : $post_data->instagram ); ?>" target="_blank"><?php echo esc_html( $post_data->instagram ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->twitter ) ) { ?>
		<p class="single-post-data-item-content"><strong>Twitter: </strong><a href="https://www.twitter.com/<?php echo esc_attr( $post_data->twitter ); ?>" target="_blank"><?php echo esc_html( $post_data->twitter ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->youtube ) ) { ?>
		<p class="single-post-data-item-content"><strong>Youtube: </strong><a href="https://www.youtube.com/<?php echo esc_attr( $post_data->youtube ); ?>" target="_blank"><?php echo esc_html( $post_data->youtube ); ?></a></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->physical_space ) ) { ?>
		<p class="single-post-data-item-content"><strong>Tipo de Espacio: </strong><?php echo esc_html( $post_data->physical_space ); ?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->cultural_group ) ) { ?>
		<p class="single-post-data-item-content"><strong>Tipo de proyecto: </strong><?php echo esc_html( $post_data->cultural_group ); ?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->other_projects ) ) { ?>
		<p class="single-post-data-item-content"><strong>Actividades que realizan: </strong><?php echo esc_html( $post_data->other_projects ); ?></p>
		<?php } ?>

		<?php if ( ! empty( $post_data->working_hours ) ) { ?>
		<p class="single-post-data-item-content"><strong>Horarios y días de funcionamiento: </strong><?php echo esc_html( $post_data->working_hours ); ?></p>
		<?php } ?>
	</div>

</section>
<div class="links-div">
    <a href="javascript:history.back()">Volver</a>
   <a href="<?php echo esc_url( get_post_type_archive_link( 'our-storys' ) ); ?>">Ver todos los proyectos</a>
</div>
<?php

get_footer();
