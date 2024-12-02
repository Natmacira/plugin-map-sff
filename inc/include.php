<?php

/**
 * Prints the form in the Front End for visitors to fill and submit it.
 *
 * @return string HTML string with the form.
 */

function map_sff_generate_form()
{
	$html  = '<form class="map-sff-ajax-form" method="post" action="' . esc_attr(admin_url('admin-ajax.php')) . '">';
	$html .= wp_nonce_field('map_sff_ajax_submit_form', 'map_sff_submit_form_nonce', true, false);
	$html .= '<h1>' . esc_html__('Share Your Story', 'map-sff') . '</h1>';
	$html .= '<p class="info-share">' . esc_html__('Your contribution helps highlight movements of resistance and change. By sharing your story, you amplify voices, inspire action, and strengthen the network of collective struggle.', 'map-sff') . '</p>';

	$html .= '<label>' . esc_html__('Name of the movement/group/ organisation', 'map-sff') . ': *<br><input class="map-sff-form-field" type="text" name="name_organization" value="" required></label>';

	$html .= '<label>' . esc_html__('Description', 'map-sff') . ': *<br><textarea class="map-sff-form-field" type="text" name="description" value="" required></textarea></label>';

	$html .= '<p>' . esc_html__('Location', 'map-sff') . ': *</p>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="location[]" value="Local" required>Local</label>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="location[]" value="National">National</label>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="location[]" value="Transnational">Transnational</label>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="location[]" value="Regional">Regional</label>';


	$html .= '<p class="inline">' . esc_html__( 'Country', 'map-sff' ) . ': *</p>';
	$html .= '<div class="multi-select-dropdown">';
	$html .= '<button type="button" onclick="toggleDropdown()">Select Countries ▼</button>';
	$html .= '<div class="dropdown-options">';
	
	// Lista de países
	$countries = [
		'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua & Deps', 
		'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas',
		'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 
		'Benin', 'Bhutan', 'Bolivia', 'Bosnia Herzegovina', 'Botswana', 'Brazil', 
		'Brunei', 'Bulgaria', 'Burkina', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 
		'Cape Verde', 'Central African Rep', 'Chad', 'Chile', 'China',
    	'Colombia', 'Comoros', 'Congo', 'Congo {Democratic Rep}', 'Costa Rica',
    	'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti',
    	'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt',
    	'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
		'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada',
    	'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras',
    	'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq',
    	'Ireland {Republic}', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica',
    	'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North',
    	'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 
		'Ghana', 'Greece', 'Grenada',
    	'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras',
    	'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq',
    	'Ireland {Republic}', 'Israel', 'Italy', 'Ivory Coast', 'Jamaica',
    	'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North', 
		'Korea South', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon',
		'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
		'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta',
		'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia',
		'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco',
		'Mozambique', 'Myanmar (Burma)', 'Namibia', 'Nauru', 'Nepal', 'Netherlands',
		'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan',
		'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines',
		'Poland', 'Portugal', 'Qatar', 'Romania', 'Russian Federation', 'Rwanda',
		'St Kitts & Nevis', 'St Lucia', 'Saint Vincent & the Grenadines', 'Samoa',
		'San Marino',
		'Sao Tome & Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 
		'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands',
		'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 
		'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 
		'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad & Tobago',
		'Tunisia', 'Turkey',
		'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates',
		'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu',
		'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
	];
	
	// Generar los checkboxes dinámicamente
	foreach ($countries as $country) {
		$html .= '<label><input type="checkbox" name="country[]" value="' . esc_attr($country) . '">' . esc_html($country) . '</label><br>';
	}
	
	$html .= '</div>'; // Cerrar dropdown-options
	$html .= '</div>'; // Cerrar multi-select-dropdown
	
	
	$html .= '<p>' . esc_html__('Category', 'map-sff') . ': *</p>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="category[]" value="Resistance" required>Resistance</label>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="category[]" value="Refusal">Refusal</label>';
	$html .= '<label class="radio"><input class="map-sff-form-field" type="radio" name="category[]" value="Both">Both</label>';
	// $html .= '<label>' . esc_html__( 'Otros', 'map-sff' ) . ': *<br><textarea class="map-sff-form-field" type="text" name="physical-space-other" value="" required></textarea></label>';
	
	$html .= '<label>' . esc_html__('Link to external source I', 'map-sff') . ': *<br><textarea class="map-sff-form-field" type="text" name="link" value="" required></textarea></label>';
	
	$html .= '<label>' . esc_html__('Link to external source II', 'map-sff') . ': *<br><textarea class="map-sff-form-field" type="text" name="other_link" value="" required></textarea></label>';

	$html .= '<label>' . esc_html__('Longitud', 'map-sff') . ': <br><textarea class="map-sff-form-field" type="text" name="longitud" value=""></textarea></label>';

	$html .= '<label>' . esc_html__('Latitud', 'map-sff') . ': <br><textarea class="map-sff-form-field" type="text" name="latitud" value=""></textarea></label>';


	$html .= '<input type="submit" value="' . esc_html__('Send', 'map-sff') . '" />';
	$html .= '<p class="map-sff-response-message"></p>';
	$html .= '</form>';

	return $html;
}
/**
 * Custom post type 'our-storys' registration callable function.
 */
function map_sff_post_type_registration()
{
	register_post_type(
		'our-storys',
		array(
			'label'                => __('Map Stories', 'map-sff'),
			'show_ui'              => true,
			'public'               => true,
			'has_archive'          => true,
			'supports'             => array('title', 'thumbnail'),
			'capabilities'         => array(
				'edit_post'          => 'manage_options',
				'read_post'          => 'manage_options',
				'delete_post'        => 'manage_options',
				'edit_posts'         => 'manage_options',
				'edit_others_posts'  => 'manage_options',
				'delete_posts'       => 'manage_options',
				'publish_posts'      => 'manage_options',
				'read_private_posts' => 'manage_options',
			),
			'register_meta_box_cb' => 'map_sff_meta_box_cb',
		)
	);
}

/**
 * Meta box registration callback for 'our-storys' post type.
 */
function map_sff_meta_box_cb()
{
	add_meta_box(
		'map_sff_meta_boxes',
		__('Datos', 'map-sff'),
		'map_sff_print_meta_boxes',
		'our-storys'
	);
}

/**
 * Adds a meta box and its fields.
 *
 * @param object $post WP Post Object.
 */
function map_sff_print_meta_boxes($post)
{
	wp_nonce_field('map_sff_meta_boxes', 'map_sff_meta_boxes_nonce');

	$metas = array(
		'description'    	=> __('Short description (2-3 sentences)', 'map-sff'),
		'name_organization' => __('Name of the movement/group/ organisation', 'map-sff'),
		'location' 			=> __('Location', 'map-sff'),
		'country'           => __('Country', 'map-sff'),
		'category'       	=> __('Category', 'map-sff'),
		'link'        		=> __('Read More - link (to internal page or external source)', 'map-sff'),
		'other_link'  		=> __('Another link', 'map-sff'),
		'tag' 				=> __('Tag', 'map-sff'),
		'latitud'        	=> __('Latitud', 'map-sff'),
		'longitud'       	=> __('Longitud', 'map-sff'),
	);

	foreach ($metas as $meta_key => $meta_label) {
		map_sff_print_meta_box($post, $meta_key, $meta_label);
	}
}

/**
 * Helps to print meta boxes html in the backend.
 *
 * @param object $post  WP Post Object.
 * @param string $name  Text to be used to complete the meta key.
 * @param string $label Text to be used to display the meta input label for the
 *                      user to see.
 */
function map_sff_print_meta_box($post, $name, $label)
{
	$input_data = get_post_meta($post->ID, 'map_sff_meta_box_' . sanitize_text_field($name), true);
?>
	<p>
		<label><strong><?php echo esc_html($label); ?></strong><br>
			<textarea class="widefat map-sff-form-field" type="text" name="<?php echo esc_attr($name); ?>"><?php echo esc_attr(! empty($input_data) ? $input_data : ''); ?></textarea>
		</label>
	</p>
<?php
}


/**
 * This function is hooked to wp_ajax and wp_ajax_nopriv. It gets the complete
 * data of all the form entries of a given page (works with pagination) and it
 * prints out the [map_sff_entries] shortcode.
 */
function map_sff_ajax_get_entries()
{
	if (
		isset($_POST['map_sff_get_entries_nonce']) &&
		wp_verify_nonce(
			sanitize_text_field(
				wp_unslash($_POST['map_sff_get_entries_nonce'])
			),
			'map_sff_ajax_get_entries'
		)
	) {
		$paged = (! empty($_POST['page-number'])) ? sanitize_text_field(wp_unslash($_POST['page-number'])) : 1;

		echo do_shortcode('[map_sff_entries paged="' . $paged . '"]');
	}
	die();
}

/**
  This function is hooked to wp_ajax and wp_ajax_nopriv. It gets the complete
  data of all the form entries of a given page (works with pagination) and it
  prints out the [map_sff_entries] shortcode.
 */
function map_sff_ajax_get_entries_map()
{
	$entries = array();

	if (
		isset($_POST['map_sff_get_entries_map_nonce']) &&
		wp_verify_nonce(
			sanitize_text_field(
				wp_unslash($_POST['map_sff_get_entries_map_nonce'])
			),
			'map_sff_ajax_get_entries_map'
		)
	) {
		// sanitize the array of countrys, location, tag, other_projects if they are not empty.
		$countrys       = (! empty($_POST['countrys']) && is_array($_POST['countrys'])) ? array_map('sanitize_text_field', $_POST['countrys']) : [];
		$locations      = (! empty($_POST['locations']) && is_array($_POST['locations'])) ? array_map('sanitize_text_field', $_POST['locations']) : [];
		$tags           = (! empty($_POST['tag']) && is_array($_POST['tag'])) ? array_map('sanitize_text_field', $_POST['tag']) : [];
		$other_projects = (! empty($_POST['other_projects']) && is_array($_POST['other_projects'])) ? array_map('sanitize_text_field', $_POST['other_projects']) : [];

		// sanitize the keyword.
		$keyword = (! empty($_POST['keyword'])) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : null;

		$args = array(
			'post_type'           => 'our-storys',
			'posts_per_page'      => -1,
			'ignore_sticky_posts' => true,
			'orderby'             => 'title',
			'order'               => 'asc',
			'post_status'         => array('publish'),
		);

		// if the keyword is not empty, add it to the args array.
		if (! empty($keyword)) {
			$args['s'] = $keyword;
		}

		$meta_query = array();

		// if the countrys array is not empty, add it to the meta_query array.
		if (! empty($countrys)) {
			$countrys_meta_query = array('relation' => 'OR');

			foreach ($countrys as $country) {
				$countrys_meta_query[] = array(
					'key'     => 'map_sff_meta_box_country',
					'value'   => $country,
					'compare' => 'LIKE',
				);
			}

			$meta_query[] = $countrys_meta_query;
		}

		// if the locations array is not empty, add it to the meta_query array.
		if (! empty($locations)) {
			$locations_meta_query = array('relation' => 'OR');

			foreach ($locations as $location) {
				$locations_meta_query[] = array(
					'key'     => 'map_sff_meta_box_location',
					'value'   => $location,
					'compare' => 'LIKE',
				);
			}

			$meta_query[] = $locations_meta_query;
		}

		// if the tags array is not empty, add it to the meta_query array.
		if (! empty($tags)) {
			$tags_meta_query = array('relation' => 'OR');

			foreach ($tags as $tag) {
				$tags_meta_query[] = array(
					'key'     => 'map_sff_meta_box_tag',
					'value'   => $tag,
					'compare' => 'LIKE',
				);
			}

			$meta_query[] = $tags_meta_query;
		}

		if (! empty($other_projects)) {
			$other_projects_meta_query = array('relation' => 'OR');

			foreach ($other_projects as $other_project) {
				$other_projects_meta_query[] = array(
					'key'     => 'map_sff_meta_box_other_projects',
					'value'   => $other_project,
					'compare' => 'LIKE',
				);
			}

			$meta_query[] = $other_projects_meta_query;
		}

		// if the meta_query array is not empty, add it to the args array.
		if (! empty($meta_query)) {
			$args['meta_query'] = $meta_query;
		}

		// get all the entries.
		$posts = get_posts($args);

		$entries = array();

		foreach ($posts as $post) {
			$entry = map_sff_get_full_entry($post);
			$entries[] = $entry;
		}
	}

	echo json_encode($entries); // phpcs:ignore WordPress.Security.EscapeOutput
	die();
}


/**
 * This function is hooked to wp_ajax and wp_ajax_nopriv. It gets the complete
 * data of a given form entry and prints it out.
 */
function map_sff_ajax_get_single_entry() {
	if ( isset( $_POST['map_sff_get_single_entry_nonce'] ) &&
		wp_verify_nonce(
			sanitize_text_field(
				wp_unslash( $_POST['map_sff_get_single_entry_nonce'] )
			),
			'map_sff_ajax_get_single_entry'
		)
	) {
		$entry_id = ( ! empty( $_POST['entry-id'] ) ) ? sanitize_text_field( wp_unslash( $_POST['entry-id'] ) ) : null;
		$entry    = get_post( $entry_id );

		if ( $entry ) {
			$full_entry = map_sff_get_full_entry( $entry );

			$html = '<p><strong>' . esc_html__( 'Nombre', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->name ) . '</p>
			<p><strong>' . esc_html__( 'Email', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->email ) . '</p>
			<p><strong>' . esc_html__( 'Espacio cultural físico', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->physical_space ) . '</p>
			<p><strong>' . esc_html__( 'Agrupación cultural', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->cultural_group ) . '</p>
			<p><strong>' . esc_html__( 'Otros proyectos', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->other_projects ) . '</p>
			<p><strong>' . esc_html__( 'Descripción', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->description ) . '</p>
			<p><strong>' . esc_html__( 'Horarios y días de funcionamiento', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->working_hours ) . '</p>
			<p><strong>' . esc_html__( 'Dirección del espacio cultural', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->address ) . '</p>
			<p><strong>' . esc_html__( 'Ciudad', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->city ) . '</p>
			<p><strong>' . esc_html__( 'Provincia', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->province ) . '</p>
			<p><strong>' . esc_html__( 'Teléfono', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->phone ) . '</p>
			<p><strong>' . esc_html__( 'Sitio web', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->website ) . '</p>
			<p><strong>' . esc_html__( 'Facebook', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->facebook ) . '</p>
			<p><strong>' . esc_html__( 'Instagram', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->instagram ) . '</p>
			<p><strong>' . esc_html__( 'Twitter', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->twitter ) . '</p>
			<p><strong>' . esc_html__( 'Youtube', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->youtube ) . '</p>
			<p><strong>' . esc_html__( 'Otras redes sociales', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->other_social ) . '</p>
			<p><strong>' . esc_html__( 'Código postal', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->postal_code ) . '</p>
			<p><strong>' . esc_html__( 'Latitud', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->latitud ) . '</p>
			<p><strong>' . esc_html__( 'Longitud', 'map-sff' ) . ':</strong> ' . esc_html( $full_entry->longitud ) . '</p>';
		}

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
	}
	die();
}

/**
 * This function is hooked to wp_ajax and wp_ajax_nopriv. It processes the
 * submissions of forms. It sends a json
 * with the result of the process.
 */
function map_sff_ajax_submit_form() {
	$error_message = '';
	$response = array(
		'post_insertion' => false,
		'message'        => '',
	);

	if ( isset( $_POST['map_sff_submit_form_nonce'] ) &&
		wp_verify_nonce(
			sanitize_text_field(
				wp_unslash( $_POST['map_sff_submit_form_nonce'] )
			),
			'map_sff_ajax_submit_form'
		)
	) {
		$name          = ( ! empty( $_POST['name_organization'] ) ) ? sanitize_text_field( wp_unslash( $_POST['name_organization'] ) ) : '';
		$description   = ( ! empty( $_POST['description'] ) ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : '';
		// $location      = ( ! empty( $_POST['location'] ) ) ? sanitize_text_field( wp_unslash( $_POST['location'] ) ) : '';

		$country       = ( ! empty( $_POST['country'] ) && is_array( $_POST['country'] ) ) ? array_map( 'sanitize_text_field', $_POST['country'] ) : [];
		$location       = ( ! empty( $_POST['location'] ) && is_array( $_POST['location'] ) ) ? array_map( 'sanitize_text_field', $_POST['location'] ) : [];
		
		$category 	   = ( ! empty( $_POST['category'] ) ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '';
		$link          = ( ! empty( $_POST['link'] ) ) ? sanitize_text_field( wp_unslash( $_POST['link'] ) ) : '';
		$other_link          = ( ! empty( $_POST['other_link'] ) ) ? sanitize_text_field( wp_unslash( $_POST['other_link'] ) ) : '';

		$latitud       = ( ! empty( $_POST['latitud'] ) ) ? sanitize_text_field( wp_unslash( $_POST['latitud'] ) ) : '';
		$longitud      = ( ! empty( $_POST['longitud'] ) ) ? sanitize_text_field( wp_unslash( $_POST['longitud'] ) ) : '';

		if ( $name && $description && $location && $country) {
			$response['post_insertion'] = wp_insert_post(
				array(
					'post_title'  => $name,
					'post_type'   => 'our-storys',
					'post_status' => 'draft',
					'meta_input'  => array(
						'map_sff_meta_box_description'    => $description,
						// 'map_sff_meta_box_location'       => $location,
						'map_sff_meta_box_country'        => implode( ',', $country ),
						'map_sff_meta_box_location'        => implode( ',', $location ),
						'map_sff_meta_box_category'       => $category,
						'map_sff_meta_box_link'           => $link,
						'map_sff_meta_box_other_link'     => $other_link,
						'map_sff_meta_box_longitud'       => $longitud,
						'map_sff_meta_box_latitud'        => $latitud,
					),
				)
			);
		} else {
			if ( empty( $name ) ) {
				$error_message .= __( 'El nombre no puede estar vacío.' );
			}

			if ( empty( $description ) ) {
				$error_message .= __( 'La descripción no puede estar vacía.' );
			}

			if ( empty( $location ) ) {
				$error_message .= __( 'El location no puede estar vacío.' );
			}

			if ( empty( $country ) ) {
				$error_message .= __( 'El campo tipo de espacio cultural físico no puede estar vacío.' );
			}

		}
	}

	do_action( 'map_sff_after_form_data_processing' );

	if ( $response['post_insertion'] ) {
		$response['message'] = __( 'Thank you for your contribution!', 'map-sff' );
		wp_send_json_success( $response );
	} else {
		$response['message'] = ! empty( $error_message ) ? $error_message : __( 'We coul not save your submission to the database. Please try again later or contact us for assistance.', 'map-sff' );
		wp_send_json_error( $response );
	}
}



/**
 * Retrieves the data of the form entries.
 *
 * @param int $paged (optional) Number of the page to fetch data.
 *
 * @return array Array with the content of the form entries and the data for
 *               creating the pagination.
 */
function map_sff_get_form_entries($paged = 1)
{
	$form_entries = array(
		'entries' => array(),
	);

	$args = array(
		'post_type'           => 'our-storys',
		'posts_per_page'      => 10,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'desc',
		'post_status'         => array('publish'),
		'paged'               => $paged,
	);

	$query = new WP_Query($args);

	if (! empty($query->posts)) {
		foreach ($query->posts as $post) {
			$form_entries['entries'][] = map_sff_get_full_entry($post);
		}
	}

	$form_entries['pagination'] = array(
		'first_page' => (1 === $paged) ? false : 1,
		'prev_page'  => (1 === $paged) ? false : $paged - 1,
		'next_page'  => (intval($query->max_num_pages) === intval($paged)) ? false : $paged + 1,
		'last_page'  => (intval($query->max_num_pages) && intval($query->max_num_pages) !== intval($paged)) ? intval($query->max_num_pages) : false,
	);

	return $form_entries;
}

/**
 * Retrieves the complete data of a form entry.
 *
 * @param WP_Post $form_entry WP Post object of 'our-storys' Post Type.
 *
 * @return Object Object created with the data of a WP Post of 'our-storys'
 *                post type and its Post Metas.
 */
function map_sff_get_full_entry($form_entry)
{
	$full_entry = new stdClass();

	$full_entry->ID                = $form_entry->ID;
	$full_entry->name              = $form_entry->post_title;
	$full_entry->name              = str_replace(array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'), array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), $form_entry->post_title);
	$full_entry->name_organization = get_post_meta($form_entry->ID, 'map_sff_meta_box_name_organization', true);
	$full_entry->location          = get_post_meta($form_entry->ID, 'map_sff_meta_box_location', true);
	$full_entry->tag               = get_post_meta($form_entry->ID, 'map_sff_meta_box_tag', true);
	$full_entry->description       = get_post_meta($form_entry->ID, 'map_sff_meta_box_description', true);
	$full_entry->link              = get_post_meta($form_entry->ID, 'map_sff_meta_box_link', true);
	$full_entry->other_link        = get_post_meta($form_entry->ID, 'map_sff_meta_box_other_link', true);
	$full_entry->country           = get_post_meta($form_entry->ID, 'map_sff_meta_box_country', true);
	$full_entry->category          = get_post_meta($form_entry->ID, 'map_sff_meta_box_category', true);
	$full_entry->longitud          = get_post_meta($form_entry->ID, 'map_sff_meta_box_longitud', true);
	$full_entry->latitud           = get_post_meta($form_entry->ID, 'map_sff_meta_box_latitud', true);
	$full_entry->permalink         = get_permalink($form_entry->ID);

	return $full_entry;
}

/**
 * Prints a table with the list of form entries (Posts of 'our-storys' post
 * type).
 *
 * @param int $paged (optional) Number of the page to be displayed (uses
 *                              pagination).
 *
 * @return string HTML string with the table and the pagination.
 */
function map_sff_print_form_entries($paged = 1)
{
	$form_entries = map_sff_get_form_entries($paged);

	$html  = '<div id="map-sff-form-entries">';
	$html .= wp_nonce_field('map_sff_ajax_get_entries', 'map_sff_get_entries_nonce', true, false);
	$html .= wp_nonce_field('map_sff_ajax_get_single_entry', 'map_sff_get_single_entry_nonce', true, false);
	$html .= '<input type="hidden" id="map-sff-endpoint" value="' . esc_attr(admin_url('admin-ajax.php')) . '">';

	$html .= '<div class="section-table"><table class="content-table">';

	$html .= '<thead>
		<tr>
			<th>' . esc_html__('Nombre', 'map-sff') . '</th>
			<th>' . esc_html__('name_organization', 'map-sff') . '</th>
			<th>' . esc_html__('Descripción', 'map-sff') . '</th>
			<th>' . esc_html__('Dirección del espacio cultural', 'map-sff') . '</th>
			<th>' . esc_html__('Ciudad', 'map-sff') . '</th>
			<th>' . esc_html__('Provincia', 'map-sff') . '</th>
			<th></th>
		</tr>
	</thead>
	<tbody>';

	if ($form_entries['entries']) {
		foreach ($form_entries['entries'] as $form_entry) {
			$html .= '<tr>
				<td>' . esc_html($form_entry->name) . '</td>
				<td>' . esc_html($form_entry->name_organization) . '</td>
				<td>' . esc_html($form_entry->description) . '</td>
				<td>' . esc_html($form_entry->address) . '</td>
				<td>' . esc_html($form_entry->country) . '</td>
				<td>' . esc_html($form_entry->category) . '</td>
				<td><button class="show-details-button" data-entry-id="' . esc_attr($form_entry->ID) . '">+</td>
			</tr>';
		}
	}

	$html .= '</tbody></table></div><div id="full-entry-result"></div>';

	$html .= '<div id="our-storys-entry-pagination">';
	$html .= '<button class="pagination-button first-page" data-page-number="' . esc_attr($form_entries['pagination']['first_page']) . '"><<</button>';
	$html .= '<button class="pagination-button prev-page" data-page-number="' . esc_attr($form_entries['pagination']['prev_page']) . '"><</button>';
	$html .= '<span class="pagination-page">' . esc_html($paged) . '</span>';
	$html .= '<button class="pagination-button next-page" data-page-number="' . esc_attr($form_entries['pagination']['next_page']) . '">></button>';
	$html .= '<button class="pagination-button last-page" data-page-number="' . esc_attr($form_entries['pagination']['last_page']) . '">>></button>';
	$html .= '</div></div>';

	return $html;
}

/**
 * Handles the saving of post of 'our-storys' custom post type.
 *
 * @param int $post_id Post ID of the post being saved.
 */
function map_sff_save_cv_post_back($post_id)
{

	if (! isset($_POST['map_sff_meta_boxes_nonce'])) {
		return;
	}

	if (! wp_verify_nonce(
		sanitize_text_field(
			wp_unslash(
				$_POST['map_sff_meta_boxes_nonce']
			)
		),
		'map_sff_meta_boxes'
	)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}

	if (! current_user_can('edit_post', $post_id)) {
		return;
	}

	if ('our-storys' !== get_post_type($post_id)) {
		return;
	}
	$name_organization          = (! empty($_POST['name_organization'])) ? sanitize_text_field(wp_unslash($_POST['name_organization'])) : '';
	$location 					= (! empty($_POST['location'])) ? sanitize_text_field(wp_unslash($_POST['location'])) : '';
	$tag 						= (! empty($_POST['tag'])) ? sanitize_text_field(wp_unslash($_POST['tag'])) : '';
	$other_projects 			= (! empty($_POST['other_projects'])) ? sanitize_text_field(wp_unslash($_POST['other_projects'])) : '';
	$description    			= (! empty($_POST['description'])) ? sanitize_text_field(wp_unslash($_POST['description'])) : '';
	$other_link  				= (! empty($_POST['other_link'])) ? sanitize_text_field(wp_unslash($_POST['other_link'])) : '';
	$country           			= (! empty($_POST['country'])) ? sanitize_text_field(wp_unslash($_POST['country'])) : '';
	$category	    			= (! empty($_POST['category'])) ? sanitize_text_field(wp_unslash($_POST['category'])) : '';
	$link        				= (! empty($_POST['link'])) ? sanitize_text_field(wp_unslash($_POST['link'])) : '';
	$longitud       			= (! empty($_POST['longitud'])) ? sanitize_text_field(wp_unslash($_POST['longitud'])) : '';
	$latitud        			= (! empty($_POST['latitud'])) ? sanitize_text_field(wp_unslash($_POST['latitud'])) : '';

	update_post_meta($post_id, 'map_sff_meta_box_name_organization', $name_organization);
	update_post_meta($post_id, 'map_sff_meta_box_location', $location);
	update_post_meta($post_id, 'map_sff_meta_box_tag', $tag);
	update_post_meta($post_id, 'map_sff_meta_box_other_projects', $other_projects);
	update_post_meta($post_id, 'map_sff_meta_box_description', $description);
	update_post_meta($post_id, 'map_sff_meta_box_other_link', $other_link);
	update_post_meta($post_id, 'map_sff_meta_box_country', $country);
	update_post_meta($post_id, 'map_sff_meta_box_category', $category);
	update_post_meta($post_id, 'map_sff_meta_box_link', $link);
	update_post_meta($post_id, 'map_sff_meta_box_longitud', $longitud);
	update_post_meta($post_id, 'map_sff_meta_box_latitud', $latitud);
}


add_action('init', 'map_sff_post_type_registration');
add_action('wp_ajax_map_sff_get_entries', 'map_sff_ajax_get_entries');
add_action('wp_ajax_nopriv_map_sff_get_entries', 'map_sff_ajax_get_entries');
add_action('wp_ajax_map_sff_get_single_entry', 'map_sff_ajax_get_single_entry');
add_action('wp_ajax_nopriv_map_sff_get_single_entry', 'map_sff_ajax_get_single_entry');
add_action('wp_ajax_map_sff_submit_form', 'map_sff_ajax_submit_form');
add_action('wp_ajax_nopriv_map_sff_submit_form', 'map_sff_ajax_submit_form');
add_action('save_post', 'map_sff_save_cv_post_back');

add_action('wp_ajax_map_sff_get_entries_map', 'map_sff_ajax_get_entries_map');
add_action('wp_ajax_nopriv_map_sff_get_entries_map', 'map_sff_ajax_get_entries_map');

add_shortcode(
	'map_sff_form',
	function ($atts) {
		wp_enqueue_script('map-sff-form');
		wp_enqueue_style('map-sff-form');

		return map_sff_generate_form();
	}
);

add_shortcode(
	'map_sff_entries_table',
	function ($atts = array()) {
		$atts = shortcode_atts(
			array(
				'paged' => 1,
			),
			$atts
		);

		if (! current_user_can('manage_options')) {
			return '<h2>' . esc_html__('You are not authorized to view the content of this page.', 'map-sff') . '</h2>';
		}

		wp_enqueue_script('map-sff-entries-table');
		wp_enqueue_style('map-sff-entries-table');

		return map_sff_print_form_entries($atts['paged']);
	}
);

add_shortcode(
	'map_sff_entries_map',
	function ($atts = array()) {
		$atts = shortcode_atts(
			array(
				'paged' => 1,
			),
			$atts
		);

		wp_enqueue_script('map-sff-entries-map');
		wp_enqueue_script('map-sff-leaflet');
		wp_enqueue_style('map-sff-leaflet');

		$posts = get_posts(
			array(
				'post_type'      => 'our-storys',
				'posts_per_page' => -1,
				'post_status'    => array('publish'),
			)
		);

		$centres = [];

		foreach ($posts as $post) {
			$centre = map_sff_get_full_entry($post);
			$centres[] = $centre;
		}

		// Localize the script with the PHP data
		wp_localize_script('map-sff-entries-map', 'centresAll', $centres);

		$html  = '';
		$html .= '<section class="centre-map-container">';

		$html .= '<div id="filter-btn-container"><button class="filter-btn">OPEN FILTERS</button></div>';

		$html .= '<form id="map-sff-filters">';
		$html .= '<img src="' . esc_url(plugins_url('../img/close.png', __FILE__)) . '" class="close-img" alt="X">';

		$html .= '<div id="details-container">';
		$html .= '<p>Select the country or location to read about Our Stories of Resistance And Strategies for Change</p>';
		$html .= '<details><summary>Country</summary>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Afghanistan">Afghanistan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Albania">Albania</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Algeria">Algeria</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Andorra">Andorra</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Angola">Angola</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Antigua & Deps">Antigua & Deps</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Argentina">Argentina</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Armenia">Armenia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Australia">Australia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Austria">Austria</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Azerbaijan">Azerbaijan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bahamas">Bahamas</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bahrain">Bahrain</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bangladesh">Bangladesh</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Barbados">Barbados</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Belarus">Belarus</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Belgium">Belgium</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Belize">Belize</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Benin">Benin</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bhutan">Bhutan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bolivia">Bolivia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bosnia Herzegovina">Bosnia Herzegovina</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Botswana">Botswana</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Brazil">Brazil</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Brunei">Brunei</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Bulgaria">Bulgaria</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Burkina">Burkina</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Burundi">Burundi</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Cambodia">Cambodia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Cameroon">Cameroon</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Canada">Canada</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Cape Verde">Cape Verde</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Central African Rep">Central African Rep</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Chad">Chad</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Chile">Chile</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="China">China</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Colombia">Colombia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Comoros">Comoros</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Congo">Congo</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Congo {Democratic Rep}">Congo {Democratic Rep}</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Costa Rica">Costa Rica</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Croatia">Croatia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Cuba">Cuba</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Cyprus">Cyprus</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Czech Republic">Czech Republic</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Denmark">Denmark</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Djibouti">Djibouti</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Dominica">Dominica</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Dominican Republic">Dominican Republic</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="East Timor">East Timor</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ecuador">Ecuador</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Egypt">Egypt</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="El Salvador">El Salvador</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Equatorial Guinea">Equatorial Guinea</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Eritrea">Eritrea</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Estonia">Estonia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ethiopia">Ethiopia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Fiji">Fiji</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Finland">Finland</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="France">France</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Gabon">Gabon</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Gambia">Gambia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Georgia">Georgia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Germany">Germany</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ghana">Ghana</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Greece">Greece</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Grenada">Grenada</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Guatemala">Guatemala</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Guinea">Guinea</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Guinea-Bissau">Guinea-Bissau</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Guyana">Guyana</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Haiti">Haiti</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Honduras">Honduras</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Hungary">Hungary</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Iceland">Iceland</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="India">India</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Indonesia">Indonesia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Iran">Iran</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Iraq">Iraq</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ireland {Republic}">Ireland {Republic}</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Israel">Israel</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Italy">Italy</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ivory Coast">Ivory Coast</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Jamaica">Jamaica</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Japan">Japan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Jordan">Jordan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kazakhstan">Kazakhstan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kenya">Kenya</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kiribati">Kiribati</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Korea North">Korea North</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Korea South">Korea South</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kosovo">Kosovo</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kuwait">Kuwait</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Kyrgyzstan">Kyrgyzstan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Laos">Laos</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Latvia">Latvia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Lebanon">Lebanon</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Lesotho">Lesotho</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Liberia">Liberia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Libya">Libya</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Liechtenstein">Liechtenstein</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Lithuania">Lithuania</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Luxembourg">Luxembourg</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Macedonia">Macedonia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Madagascar">Madagascar</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Malawi">Malawi</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Malaysia">Malaysia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Maldives">Maldives</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mali">Mali</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Malta">Malta</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Marshall Islands">Marshall Islands</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mauritania">Mauritania</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mauritius">Mauritius</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mexico">Mexico</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Micronesia">Micronesia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Moldova">Moldova</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Monaco">Monaco</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mongolia">Mongolia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Montenegro">Montenegro</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Morocco">Morocco</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Mozambique">Mozambique</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Myanmar, {Burma}">Myanmar, {Burma}</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Namibia">Namibia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Nauru">Nauru</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Nepal">Nepal</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Netherlands">Netherlands</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="New Zealand">New Zealand</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Nicaragua">Nicaragua</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Niger">Niger</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Nigeria">Nigeria</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Norway">Norway</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Oman">Oman</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Pakistan">Pakistan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Palau">Palau</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Panama">Panama</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Papua New Guinea">Papua New Guinea</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Paraguay">Paraguay</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Peru">Peru</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Philippines">Philippines</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Poland">Poland</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Portugal">Portugal</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Qatar">Qatar</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Romania">Romania</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Russian Federation">Russian Federation</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Rwanda">Rwanda</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="St Kitts & Nevis">St Kitts & Nevis</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="St Lucia">St Lucia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Saint Vincent & the Grenadines">Saint Vincent & the Grenadines</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Samoa">Samoa</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="San Marino">San Marino</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Sao Tome & Principe">Sao Tome & Principe</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Saudi Arabia">Saudi Arabia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Senegal">Senegal</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Serbia">Serbia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Seychelles">Seychelles</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Sierra Leone">Sierra Leone</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Singapore">Singapore</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Slovakia">Slovakia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Slovenia">Slovenia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Solomon Islands">Solomon Islands</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Somalia">Somalia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="South Africa">South Africa</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="South Sudan">South Sudan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Spain">Spain</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Sri Lanka">Sri Lanka</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Sudan">Sudan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Suriname">Suriname</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Swaziland">Swaziland</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Sweden">Sweden</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Switzerland">Switzerland</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Syria">Syria</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Taiwan">Taiwan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Tajikistan">Tajikistan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Tanzania">Tanzania</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Thailand">Thailand</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Togo">Togo</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Tonga">Tonga</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Trinidad & Tobago">Trinidad & Tobago</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Tunisia">Tunisia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Turkey">Turkey</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Turkmenistan">Turkmenistan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Tuvalu">Tuvalu</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Uganda">Uganda</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Ukraine">Ukraine</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="United Arab Emirates">United Arab Emirates</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="United Kingdom">United Kingdom</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="United States">United States</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Uruguay">Uruguay</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Uzbekistan">Uzbekistan</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Vanuatu">Vanuatu</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Vatican City">Vatican City</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Venezuela">Venezuela</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Vietnam">Vietnam</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Yemen">Yemen</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Zambia">Zambia</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="country[]" value="Zimbabwe">Zimbabwe</label>';
		$html .= '</details>';

		$html .= '<details><summary>Location</summary>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="location[]" value="Local">Local</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="location[]" value="National">National</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="location[]" value="Transnational">Transnational</label>';
		$html .= '<label><input class="map-sff-filter" type="checkbox" name="location[]" value="Regional">Regional</label>';
		$html .= '</details>';

		$html .= '<details><summary></summary>';

		$html .= '</details>';
		$html .= '</div>';

		$html .= '<label class="standalone-input-label">Name of the story: ';
		$html .= '<input class="map-sff-filter" type="text" name="keyword" placeholder="Write the name">';
		$html .= '</label>';

		$html .= '<button id="clear-filters" type="button">Reset Filters</button>';
		$html .= '<button id="load-map">Search</button>';
		$html .= '</form>';

		$html .= '<div id="map"></div>';
		$html .= '<div id="hint" class="empty"><p>Use the filters to search for projects.</p></div>';
		$html .= '</section>';
		$html .= wp_nonce_field('map_sff_ajax_get_entries_map', 'map_sff_get_entries_map_nonce', true, false);
		$html .= '<input type="hidden" id="map-sff-endpoint" value="' . esc_attr(admin_url('admin-ajax.php')) . '">';

		return $html;
	}
);



// Add a shortcode to display the "how to use" section
add_shortcode(
	'map_sff_what_is_it',
	function () {
		$html = '';

		$html .= '<section id="que-es-el-mapa" class="what-is-it-container card-rounded">';

		$html .= '<article>';

		$html .= '<h2>¿Que es el Mapa Federal de Cultura?</h2>';

		$html .= '<p>Es una herramienta interactiva para localizar agrupaciones, espacios y movidas culturales LGBTIQ+ lo largo y ancho de la Argentina. Su objetivo es crear una agenda federal de propuestas en todo el país construida entre todxs para posibilitar articulaciones, visibilizar proyectos y tejer redes.</p>';

		$html .= '</article>';

		$html .= '<figure class="image-container"><img src="' . esc_url(get_stylesheet_directory_uri() . '/img/logo-mapa.png') . '"></figure>';

		$html .= '</section>';

		return $html;
	}
);

// Add a shortcode to display the "how to use" section
add_shortcode(
	'map_sff_how_to_use',
	function () {
		$html = '';

		$html .= '<section id="como-usar-el-mapa" class="how-to-use-container">';

		$html .= '<h2>Como usar el mapa</h2>';

		$html .= '<article class="card-rounded">';

		$html .= '<div class="text-container">';
		$html .= '<h3>Encontra el proyecto cultural mas cercano</h3>';
		$html .= '<p>Navegá el mapa para encontrar los espacios más cercanos a tu ubicación, estés donde estés.</p>';
		$html .= '</div>';

		$html .= '<figure class="image-container"><img src="' . esc_url(get_stylesheet_directory_uri() . '/img/mapa.png') . '" alt="Captura de pantalla del mapa"></figure>';

		$html .= '</article>';

		$html .= '<article class="card-rounded">';

		$html .= '<div class="text-container">';
		$html .= '<h3>Filtra lo que te interese</h3>';
		$html .= '<p>Seleccioná los planes culturales que más se ajusten a lo que querés, desde marchas hasta asociaciones civiles.</p>';
		$html .= '</div>';

		$html .= '<figure class="image-container"><img src="' . esc_url(get_stylesheet_directory_uri() . '/img/filtros-de-mapa.png') . '" alt="Captura de los filtros del mapa"></figure>';

		$html .= '</article>';

		$html .= '<article class="card-rounded">';

		$html .= '<div class="text-container">';
		$html .= '<h3>Conoce mas espacios</h3>';
		$html .= '<p>El Mapa Federal tiene la ubicación y datos de contacto de cada espacio: podés entrar a sus redes o contactarte desde un solo lugar.</p>';
		$html .= '</div>';

		$html .= '<figure class="image-container"><img src="' . esc_url(get_stylesheet_directory_uri() . '/img/otros-espacios.png') . '"></figure>';

		$html .= '</article>';


		$html .= '</section>';

		return $html;
	}
);

// Add a shortcode to display the entries
add_shortcode(
	'map_sff_centres_list',
	function () {
		$args = array(
			'post_type'           => 'our-storys',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'orderby'             => 'rand',
			'order'               => 'desc',
			'post_status'         => array('publish'),
		);

		$html  = '';
		$query = new WP_Query($args);

		$html  .= '<section class="centres-list-container">';

		$html .= '<h2>Conoce los proyectos</h2>';

		if (! empty($query->posts)) {
			$html  .= '<div class="centres-list-inner-container">';

			foreach ($query->posts as $post) {
				$html .= map_sff_print_entry($post);
			}

			$html  .= '</div>';
		}

		$html .= '<a class="button-link archive-link" href="' . esc_url(get_post_type_archive_link('our-storys')) . '">Ver todos los proyectos</a>';

		$html .= '</section>';

		return $html;
	}
);

// Add a shortcode to display the "mercuria" section
// add_shortcode(
// 	'map_sff_mercuria',
// 	function () {
// 		$html = '';

// 		$html .= '<section class="mercuria-container card-rounded">';

// 		$html .= '<article>';

// 		$html .= '<h2>¿Que es Mercuria?</h2>';

// 		$html .= '<p>Somos una cooperativa cultural transfeminista con perspectiva federal, conformada por artistas, trabajadorxs y gestorxs de la cultura. Trabajamos para fomentar la expresión de todas las comunidades argentinas, visibilizando proyectos inclusivos y plurales para todes.</p>';

// 		$html .= '</article>';

// 		$html .= '<figure class="image-container"><img src="' . esc_url(get_stylesheet_directory_uri() . '/img/logo-mercuria.png') . '"></figure>';

// 		$html .= '</section>';

// 		return $html;
// 	}
// );


// Add a shortcode to display the amount of entries.
add_shortcode(
	'mapa_federal_entries_count',
	function () {
		$args = array(
			'post_type'      => 'our-storys',
			'posts_per_page' => -1,
			'post_status'    => array( 'publish' ),
		);

		$query = new WP_Query( $args );

		$html = '';

		$html .= '<section class="centre-count-container">';

		$html .= '<p class="centre-count" data-val="' . esc_attr( $query->found_posts ) . '">0</p>';

		$html .= '<h3>Shared stories</h3>';

		// $html .= '<a class="button-link form-link" href="https://docs.google.com/forms/d/e/1FAIpQLSdMk_RuMv0kQ_Ddld6wC2UpKrRSQdK0S3aRy0RGA7ykjMM8mQ/viewform" target="_blank">Suma tu espacio</a>';

		// $html .= '<h4>Carga los datos de tu espacio para que aparezca en el mapa</h4>';

		$html .= '</section>';

		return $html;
	}
);