<?php
/**
 * Plugin Name: Custom Map 
 * Version:     0.3.2
 * Description: Plugin para mapas
 * Author:      Natalia Ciraolo & Lucía Cáceres 
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


if ( ! defined( 'MAPA_FEDERAL_VERSION' ) ) {
	define( 'MAPA_FEDERAL_VERSION', '0.3.2' );
}

require plugin_dir_path( __FILE__ ) . '/inc/include.php';

add_action(
	'widgets_init',
	function() {
		register_sidebar(
			array(
				'name'          => 'Mapa Federal',
				'id'            => 'map-sff',
				'class'         => '',
				'before_widget' => '<div class="widget map-sff">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			)
		);
	}
);

add_action( 'wp_enqueue_scripts', 'map_sff_enqueue_scripts' );

/**
 * Styles and scripts enqueuing callable function.
 */
function map_sff_enqueue_scripts() {
	wp_enqueue_style( 'map-sff', plugin_dir_url( __FILE__ ) . '/assets/css/style.min.css', array(), MAPA_FEDERAL_VERSION );
	wp_enqueue_script( 'map-sff', plugin_dir_url( __FILE__ ) . '/assets/js/main.js', array(), MAPA_FEDERAL_VERSION, true );

	wp_register_script( 'map-sff-ajax', plugin_dir_url( __FILE__ ) . '/assets/js/ajax.js', array(), MAPA_FEDERAL_VERSION, true );

	wp_register_script( 'map-sff-form', plugin_dir_url( __FILE__ ) . '/assets/js/form.js', array( 'map-sff-ajax' ), MAPA_FEDERAL_VERSION, true );

	wp_register_style( 'map-sff-form', plugin_dir_url( __FILE__ ) . '/assets/css/form.css', array(), MAPA_FEDERAL_VERSION );

	wp_register_script( 'map-sff-entries-table', plugin_dir_url( __FILE__ ) . '/assets/js/entries-table.js', array( 'map-sff-ajax' ), MAPA_FEDERAL_VERSION, true );

	wp_register_style( 'map-sff-entries-table', plugin_dir_url( __FILE__ ) . '/assets/css/entries-table.css', array(), MAPA_FEDERAL_VERSION );

	wp_register_script( 'map-sff-entries-map', plugin_dir_url( __FILE__ ) . '/assets/js/entries-map.js', array( 'map-sff-ajax' ), MAPA_FEDERAL_VERSION, true );

	wp_register_style( 'map-sff-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.css', array(), MAPA_FEDERAL_VERSION );

	wp_register_script( 'map-sff-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js', array(), MAPA_FEDERAL_VERSION, true );

	$posts = get_posts(
		array(
			'post_type'      => 'our-storys',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish' ),
		)
	);

	$centres = [];

	foreach ( $posts as $post ) {
		$centre = map_sff_get_full_entry( $post );
		$centres[] = $centre;
	}

	// Localize the script with the PHP data
	wp_localize_script( 'map-sff-entries-map', 'centresAll', $centres );

}

/**
 * Prints a post.
 *
 * @param int   $post_id Optional. The post to print. If null it will be print
 *                       the current post. Default null.
 * @param array $atts {
 *  Optional. Extra arguments to be sent to the function.
 *
 *  @type string  $thumbnail_size Which thumbnail size to use. Default large.
 *  @type boolean $output         Whether to output the content or not. Default
 *                                true.
 * }
 *
 * @return void|string The HTML representing the post if $atts['output'] is
 *                     true.
 */
function map_sff_print_post( $post_id = null, $atts = array() ) {
	$html = '';

	$atts = shortcode_atts(
		array(
			'thumbnail_size' => 'large',
			'output'         => true,
		),
		$atts
	);

	if ( empty( $post_id ) ) {
		$post_id = get_the_ID();
	}

	$post = get_post( $post_id );

	if ( $post ) {
		/* $image = get_the_post_thumbnail( $post_id, $atts['thumbnail_size'] ); */
		$link  = get_permalink( $post_id );
		$title = $post->post_title;
		$date  = get_the_date( get_option( 'date_format' ), $post_id );

		$html .= '<article id="article-' . esc_attr( $post_id ) . '">';

	
		if ( ! is_single() ) {
			$html .= '<h2><a href="' . esc_url( $link ) . '" title="' . esc_attr( $title ) . '">' . esc_html( $title ) . '</a></h2>';
		}

		if ( get_post_type( $post_id ) === 'post' ) {
			$html .= '<div class="toolbar">';
			$html .= '<p> ' . esc_html( $date ) . '</p>';
			$html .= '</div>';
		}

		if ( is_singular( array( 'post' ) ) ) {
			$html .= '<div class="content">';

			$html .= wp_kses_post( apply_filters( 'the_content', $post->post_content ) );

			$html .= '</div>';
			$html .= '<div class="tags">';

			the_tags( '', '' );
			$html .= '</div>';
		} else {
			if ( $post->post_excerpt ) {
				$html .= '<div class="content">';

				$html .= map_sff_print_excerpt( $post, 100, false );

				$html .= '<a href="' . esc_url( $link ) . '" title="' . esc_attr( $title ) . '" class="read-more">';
				$html .= esc_html__( 'More', 'map-sff' ) . '</a>';
				$html .= '</div>';
			} elseif ( $post->post_content ) {
				$html .= '<div class="content">';

				$html .= wp_kses_post( apply_filters( 'the_content', $post->post_content ) );

				$html .= '<a href="' . esc_url( $link ) . '" title="' . esc_attr( $title ) . '" class="read-more">';
				$html .= esc_html__( 'More', 'map-sff' ) . '</a>';
				$html .= '</div>';
			}
		}

		$html .= '</article>';
	}

	if ( $atts['output'] ) {
		echo wp_kses_post( $html );
	} else {
		return $html;
	}
}
/**
 * Returns post excerpt.
 *
 * @param WP_Post $post      Post object.
 * @param int     $num_words Optional. Maximum number of words to return.
 *                           Default 55.
 *
 * @return string Post excerpt.
 */
function map_sff_get_excerpt( $post, $num_words = 55 ) {
	if ( ! empty( $post->post_excerpt ) ) {
		$excerpt = $post->post_excerpt;
	} else {
		$excerpt = strip_shortcodes( $post->post_content );
		$excerpt = wp_strip_all_tags( $excerpt );
	}

	$excerpt = wp_trim_words( $excerpt, $num_words );

	return $excerpt;
}
/**
 * Prints current post excerpt.
 *
 * @param WP_Post $post      Post object.
 * @param int     $num_words Optional. Maximum number of words to return.
 *                           Default 100.
 * @param boolean $output    Optional. Whether to output the content or return
 *                           it. Default true.
 *
 * @return void|string Post excerpt if $output is true.
 */
function map_sff_print_excerpt( $post, $num_words = 100, $output = true ) {
	if ( $output ) {
		echo esc_html( map_sff_get_excerpt( $post, $num_words ) );
	} else {
		return esc_html( map_sff_get_excerpt( $post, $num_words ) );
	}
}

add_filter(
	'wp_kses_allowed_html',
	function( $allowed, $context ) {
		if ( 'post' === $context ) {
			$allowed['select']   = array(
				'name'     => true,
				'id'       => true,
				'required' => true,
			);

			$allowed['option']   = array(
				'value' => true,
			);

			$allowed['textarea'] = array(
				'name'        => true,
				'placeholder' => true,
				'id'          => true,
				'class'       => true,
				'required'    => true,
			);

			$allowed['input']    = array(
				'type'        => true,
				'name'        => true,
				'placeholder' => true,
				'value'       => true,
				'id'          => true,
				'class'       => true,
				'checked'     => true,
				'required'    => true,
			);

			$allowed['script'] = array(
				'type' => true,
				'src'  => true,
			);

			$allowed['link'] = array(
				'rel'  => true,
				'href' => true,
			);

			$allowed['div']['data-value'] = true;
			$allowed['div']['data-mask']  = true;
			$allowed['div']['onclick']    = true;
			$allowed['a']['download']     = true;

			$allowed['iframe']                = array();
			$allowed['iframe']['class']       = true;
			$allowed['iframe']['width']       = true;
			$allowed['iframe']['height']      = true;
			$allowed['iframe']['frameborder'] = true;
			$allowed['iframe']['src']         = true;
			$allowed['iframe']['scrolling']   = true;

			$allowed['form'] = array(
				'id'          => true,
				'class'       => true,
			);
		}

		return $allowed;
	},
	10,
	2
);



function map_sff_print_entry( $post ) {
    $html               = '';
    $centre_name        = str_replace( array( 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú' ), array( 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U' ), $post->post_title );
    $centre_description = get_post_meta( $post->ID, 'map_sff_meta_box_description', true );

    // Limitar la descripción a 50 palabras
    $centre_description = limitar_contenido($centre_description);

    $html .= '<article class="centre-post card-rounded">';
    $html .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
    $html .= '<h3>' . esc_html( $centre_name ) . '</h3>';
    $html .= '<p>' . esc_html( $centre_description ) . '</p>';

    if ( has_post_thumbnail( $post->ID ) ) {
        $html .= '<figure class="thumbnail-container">';
        $html .= get_the_post_thumbnail( $post->ID, 'medium' );
        $html .= '</figure>';
    }

    $html .= '</a>';
    $html .= '</article>';

    return $html;
}

// Función para limitar el contenido a 50 palabras
function limitar_contenido($contenido) {
    $palabras = explode(' ', $contenido);
    $conteo_palabras = count($palabras);

    if ($conteo_palabras > 30) {
        $contenido_limitado = implode(' ', array_slice($palabras, 0, 50)) . '...';
        return $contenido_limitado;
    } else {
        return $contenido;
    }
}
