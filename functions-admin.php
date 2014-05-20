<?php 

/* Customizer additions */

/**
 * Add logo upload in theme customizer screen.
 *
 * @since 1.0
 */
function compete_themes_customize_register_logo( $wp_customize ) {

	/* Add the layout section. */
	$wp_customize->add_section(
		'ct-logo',
		array(
			'title'      => esc_html__( 'Logo Upload', 'done' ),
			'priority'   => 30,
			'capability' => 'edit_theme_options'
		)
	);
	/* Add the 'logo' setting. */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url',
			//'transport'         => 'postMessage'
		)
	);
    /* add file upload control */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'logo_image',
				array(
					'label'    => esc_html__( 'Upload custom logo.', 'done' ),
					'section'  => 'ct-logo',
					'settings' => 'logo_upload',
			)
		)
	);
}
add_action( 'customize_register', 'compete_themes_customize_register_logo' );

function compete_themes_customize_logo_positioning( $wp_customize ) {

    /* create custom control for number input */
    class compete_themes_number_input_control extends WP_Customize_Control {
        public $type = 'number';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" />
            </label>
        <?php
        }
    }

    /* Add the layout section. */
    $wp_customize->add_section(
        'ct-logo-positioning',
        array(
            'title'      => esc_html__( 'Logo Positioning', 'done' ),
            'priority'   => 31,
            'capability' => 'edit_theme_options'
        )
    );
    /* logo positioning top setting. */
    $wp_customize->add_setting(
        'logo_positioning_updown_setting',
        array(
            'default' => 0
            //'sanitize_callback' => 'int',
        )
    );
    /* logo positioning right setting. */
    $wp_customize->add_setting(
        'logo_positioning_leftright_setting',
        array(
            'default' => 0
            //'sanitize_callback' => 'int',
        )
    );
    /* top input */
    $wp_customize->add_control(
        new compete_themes_number_input_control(
            $wp_customize, 'logo_positioning_updown_setting',
            array(
                'label' => 'Up/down',
                'section' => 'ct-logo-positioning',
                'settings' => 'logo_positioning_updown_setting',
                'type' => 'number',
            )
        )
    );
    /* right input */
    $wp_customize->add_control(
        new compete_themes_number_input_control(
            $wp_customize, 'logo_positioning_leftright_setting',
            array(
                'label' => 'Left/right',
                'section' => 'ct-logo-positioning',
                'settings' => 'logo_positioning_leftright_setting',
                'type' => 'number',
            )
        )
    );
}
add_action( 'customize_register', 'compete_themes_customize_logo_positioning' );

/* creates array used to get social media site names */
function compete_themes_customizer_social_media_array() {

	// store social site names in array
	$social_sites = array('twitter', 'facebook', 'google-plus', 'flickr', 'pinterest', 'youtube', 'vimeo', 'tumblr', 'dribbble', 'rss', 'linkedin', 'instagram');
	
	return $social_sites;
}

/* add settings to create various social media text areas */
function compete_themes_add_social_sites_customizer($wp_customize) {

	$wp_customize->add_section( 'compete_themes_social_settings', array(
			'title'          => 'Social Media Icons',
			'priority'       => 35,
            'description'    => 'remember to add "http://" before each URL'
	) );
		
	$social_sites = compete_themes_customizer_social_media_array();
	$priority = 5;
	
	foreach($social_sites as $social_site) {

		$wp_customize->add_setting( "$social_site", array(
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_control( $social_site, array(
				'label'   => __( "$social_site url:", 'compete_themes_icon' ),
				'section' => 'compete_themes_social_settings',
				'type'    => 'text',
				'priority'=> $priority,
		) );
	
		$priority = $priority + 5;
	}
}
add_action('customize_register', 'compete_themes_add_social_sites_customizer');

/* lets users change the colors of the theme */
function compete_themes_custom_colors($wp_customize) {

    /* Add the color section. */
    $wp_customize->add_section(
        'ct-colors',
        array(
            'title'      => esc_html__( 'Colors', 'done' ),
            'priority'   => 60,
            'capability' => 'edit_theme_options'
        )
    );
    /* Add the color setting. */
    $wp_customize->add_setting(
        'compete_themes_accent_color',
        array(
            'default'           => '#3cbd78',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            //'transport'         => 'postMessage'
        )
    );
    /* add the color picker */
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'accent_color',
            array(
                'label'      => __( 'Accent Color', 'done' ),
                'section'    => 'ct-colors',
                'settings'   => 'compete_themes_accent_color',
            ) )
    );
    /* Add the color setting. */
    $wp_customize->add_setting(
        'compete_themes_accent_color_dark',
        array(
            'default'           => '#2c8a58',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            //'transport'         => 'postMessage'
        )
    );
    /* add the color picker */
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'accent_color_dark',
            array(
                'label'      => __( 'Accent Color (Dark)', 'done' ),
                'section'    => 'ct-colors',
                'settings'   => 'compete_themes_accent_color_dark',
            ) )
    );
}
add_action('customize_register', 'compete_themes_custom_colors');

function compete_themes_customize_layout_options( $wp_customize ) {

    /* Add the layout section. */
    $wp_customize->add_section(
        'ct-layout',
        array(
            'title'      => esc_html__( 'Layout', 'done' ),
            'priority'   => 70,
            'capability' => 'edit_theme_options'
        )
    );
    /* Add the color setting. */
    $wp_customize->add_setting(
        'compete_themes_layout_settings',
        array(
            'default'           => 'right',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'compete_themes_sanitize_layout_settings',
            //'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
            'compete_themes_sidebar_layout',
            array(
                'label'          => __( 'Sidebar on left or right?', 'done' ),
                'section'        => 'ct-layout',
                'settings'       => 'compete_themes_layout_settings',
                'type'           => 'radio',
                'choices'        => array(
                    'right'   => 'Right',
                    'left'  => 'Left'
                )
            )
    );
}
add_action( 'customize_register', 'compete_themes_customize_layout_options' );

function compete_themes_sanitize_layout_settings($input){
    $valid = array(
        'right' => 'Right',
        'left' => 'Left'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/* Custom meta boxes here */

/* creates meta box for the client name used on Project pages */
function compete_themes_project_meta_boxes( $meta_boxes ) {
    $prefix = 'ct-done-';
    $meta_boxes[] = array(
		'id'         => 'project-meta-boxes',
		'title'      => 'Project Details',
		'pages'      => array( 'done_project', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
            array(
				'name' => 'Client Name',
				'desc' => 'Who was the project for?',
				'id'   => $prefix . 'project-client-meta-box',
				'type' => 'text_medium',
			),
            array(
                'name' => 'Client Website',
                'desc' => 'URL of client website',
                'id'   => $prefix . 'project-client-url-meta-box',
                'type' => 'text_medium',
            ),
            array(
                'name' => 'Project Date',
                'desc' => 'When did you work on it?',
                'id'   => $prefix . 'project-date-meta-box',
                'type' => 'text_medium',
            )
        )
    );

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'compete_themes_project_meta_boxes' );


/* creates array used to get social media site names */
function compete_themes_create_social_array() {

	$social_sites = array(
		'twitter' => 'twitter_profile',
		'facebook' => 'facebook_profile',
		'googleplus' => 'googleplus_profile',
		'pinterest' => 'pinterest_profile',
		'linkedin' => 'linkedin_profile',
		'youtube' => 'youtube_profile',
		'vimeo' => 'vimeo_profile',
		'tumblr' => 'tumblr_profile',
		'instagram' => 'instagram_profile',
		'flickr' => 'flickr_profile',
		'dribbble' => 'dribbble_profile',
        'RSS' => 'rss_profile'
	);
	
	return $social_sites;
}

/* adds meta box on user profile for title used on post page author meta section */
function compete_themes_add_job_title_field($user){
    ?>
    <h3>Your Occupation/Title</h3>
    <table class="form-table">
        <th>
            <label for="ct-job-title">Job Title:</label>
        </th>
        <td>
            <input type='text' id='ct-job-title' class='regular-text' name='ct-job-title' value='<?php echo esc_attr(get_the_author_meta('ct-job-title', $user->ID )); ?>' />
        </td>
        </tr>
    </table>
<?php
}
add_action( 'show_user_profile', 'compete_themes_add_job_title_field' );
add_action( 'edit_user_profile', 'compete_themes_add_job_title_field' );

/* save the job title input if user has the capability to */
function compete_themes_save_job_title($user_id) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'ct-job-title', $_POST['ct-job-title'] );

}
add_action( 'personal_options_update', 'compete_themes_save_job_title' );
add_action( 'edit_user_profile_update', 'compete_themes_save_job_title' );

/* add the social profile boxes to the user screen */
function compete_themes_add_social_profile_settings($user) {
	
	$social_sites = compete_themes_create_social_array();
	
	?>	
    <table class="form-table">
        <tr>
            <th><h3>Social Profiles</h3></th>
        </tr>
        <?php
        	foreach($social_sites as $key => $social_site) {
  				?>      	
        		<tr>
					<td>
						<label for="<?php echo $key; ?>-profile"><?php echo ucfirst($key); ?> Profile:</label>
					</td>
					<td>
						<input type='url' id='<?php echo $key; ?>-profile' class='regular-text' name='<?php echo $key; ?>-profile' value='<?php echo esc_attr(get_the_author_meta($social_site, $user->ID )); ?>' />
					</td>
					</td>
				</tr>
        	<?php }	?>
    </table>
    <?php
}
add_action( 'show_user_profile', 'compete_themes_add_social_profile_settings' );

function compete_themes_save_social_profiles($user_id) {

	$social_sites = compete_themes_create_social_array();
   	
   	foreach ($social_sites as $key => $social_site) {
		if( isset( $_POST["$key-profile"] ) ){
			update_user_meta( $user_id, $social_site, esc_attr( $_POST["$key-profile"] ) );
		}
	}
}

add_action( 'personal_options_update', 'compete_themes_save_social_profiles' );

// adds widget that aside uses to give people access to support
function compete_themes_add_dashboard_widget() {

	wp_add_dashboard_widget(
                 'compete_themes_dashboard_widget',    // Widget slug.
                 'Support Dashboard',   // Title.
                 'compete_themes_widget_contents' 	  // Display function.
        );	
        
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
 	global $wp_meta_boxes;
 	
 	// Get the regular dashboard widgets array 
 	// (which has our new widget already but at the end)
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	
 	// Backup and delete our new dashboard widget from the end of the array
 	$example_widget_backup = array( 'compete_themes_dashboard_widget' => $normal_dashboard['compete_themes_dashboard_widget'] );
 	unset( $normal_dashboard['compete_themes_dashboard_widget'] );
 
 	// Merge the two arrays together so our widget is at the beginning
 	$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
 
 	// Save the sorted array back into the original metaboxes 
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
add_action( 'wp_dashboard_setup', 'compete_themes_add_dashboard_widget' );

// outputs contents for widget created by aside_add_dashboard_widget
function compete_themes_widget_contents() { ?>

    <ol>
        <li>For self-help, <a target="_blank" href="http://www.competethemes.com/documentation/done-knowledgebase/?utm_source=WordPress%20Dashboard&utm_medium=User%20Admin&utm_content=Done&utm_campaign=Admin%20Support%20Widgets">visit the knowledgebase</a></li>
        <li>To contact support, email us at <a href="mailto:support@competethemes.com">support@competethemes.com</a></li>
    </ol>
	
	<?php
}

function compete_themes_support_widget_styles() {

    echo "
    <style>
        #compete_themes_dashboard_widget{background: white;}
        #compete_themes_dashboard_widget h3{background: #E54C56; color: white;}
    </style>";

}

add_action('admin_head', 'compete_themes_support_widget_styles');

?>