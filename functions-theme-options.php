<?php
/**
 * CMB Theme Options
 * @version 0.1.0
 */
class ct_theme_options_admin {

    /**
     * Option key, and option page slug
     * @var string
     */
    protected static $key = 'ct_theme_options';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected static $theme_options = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = 'Theme Options 2';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
        // Set our title
        $this->title = __( 'Theme Options', 'ct-' );
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( self::$key, self::$key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', self::$key, array( $this, 'admin_page_display' ) );
    }

    /**
     * Admin page markup. Mostly handled by CMB
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>
        <div class="wrap cmb_options_page <?php echo self::$key; ?>">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <p>Below are the options for the contact banner.
            General customization options are available in the <a href="../wp-admin/customize.php">customize menu</a>.</p>
            <h3>Banner Options</h3>
            <?php cmb_metabox_form( self::option_fields(), self::$key ); ?>
            <br />
            <p>Can't find what you're looking for? It's probably in the <a href="../wp-admin/customize.php">customize menu</a>.</p>
        </div>
    <?php
    }

    /**
     * Defines the theme option metabox and field configuration
     * @since  0.1.0
     * @return array
     */
    public static function option_fields() {

        // Only need to initiate the array once per page-load
        if ( ! empty( self::$theme_options ) )
            return self::$theme_options;

        self::$theme_options = array(
            'id'         => 'theme_options',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( self::$key, ), ),
            'show_names' => true,
            'fields'     => array(
                array(
                    'name' => __( 'Banner Heading', 'ct-' ),
                    'desc' => __( 'The heading that shows up top', 'ct-' ),
                    'id'   => 'banner_heading',
                    'type' => 'text',
                ),
                array(
                    'name' => __( 'Button Text', 'ct-' ),
                    'desc' => __( 'The text that shows inside the button', 'ct-' ),
                    'id'   => 'banner_button_text',
                    'type' => 'text_medium',
                ),
                array(
                    'name' => __( 'Background Image', 'ct-' ),
                    'desc' => __( 'shows behind colored overlay', 'ct-' ),
                    'id'   => 'banner_background_image',
                    'type' => 'file',
                    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
                ),
                array(
                    'name' => __( 'Use Gravatar for Image?', 'ct-' ),
                    'desc' => __( 'Would you like to use your admin email Gravatar?', 'ct-' ),
                    'id'   => 'banner_main_image',
                    'type' => 'radio',
                    'std'  => 'yes',
                    'options' => array(
                        array( 'name' => 'Yes', 'value' => 'yes' ),
                        array( 'name' => 'No', 'value' => 'no' ),
                    ),
                ),
                array(
                    'name' => __( 'Upload Main Image', 'ct-' ),
                    'desc' => __( 'add custom image by uploading or selecting from Media', 'ct-' ),
                    'id'   => 'banner_image_upload',
                    'type' => 'file',
                    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
                ),
                array(
                    'name' => __( 'Content Heading', 'ct-' ),
                    'desc' => __( 'The heading that shows below your image', 'ct-' ),
                    'id'   => 'banner_content_heading',
                    'type' => 'text',
                ),
                array(
                    'name' => 'Main Content',
                    'desc' => 'let visitors know why they should contact you',
                    'id' => 'banner_textarea',
                    'type' => 'textarea'
                ),
                array(
                    'name' => __( 'Use Your Display Name as Author?', 'ct-' ),
                    'desc' => __( 'Who should be quoted for the above content?', 'ct-' ),
                    'id'   => 'banner_author_radio',
                    'type' => 'radio',
                    'std'  => 'yes',
                    'options' => array(
                        array( 'name' => 'Yes', 'value' => 'yes' ),
                        array( 'name' => 'No', 'value' => 'no' ),
                    ),
                ),
                array(
                    'name' => __( 'Author', 'ct-' ),
                    'desc' => __( 'Name of person/organization to be quoted for the main content?', 'ct-' ),
                    'id'   => 'banner_author',
                    'type' => 'text_medium',
                ),
                array(
                    'name' => __( 'Contact Form', 'ct-' ),
                    'id'   => 'banner_contact_form',
                    'type' => 'radio',
                    'std'  => 'built-in',
                    'options' => array(
                        array( 'name' => 'Use Built-in Contact Form', 'value' => 'built-in' ),
                        array( 'name' => 'Use a Shortcode', 'value' => 'shortcode' ),
                    ),
                ),
                array(
                    'name' => __( 'Contact Form Shortcode', 'ct-' ),
                    'desc' => __( 'Use a shortcode from any contact form plugin instead', 'ct-' ),
                    'id'   => 'banner_contact_form_shortcode',
                    'type' => 'text_medium',
                ),
                array(
                    'name' => __( 'Contact Email', 'ct-' ),
                    'desc' => __( 'Who should receive the emails from the contact form?', 'ct-' ),
                    'id'   => 'banner_contact_form_email',
                    'type' => 'text_medium',
                ),
                array(
                    'name' => __( 'Display Options', 'ct-' ),
                    'id'   => 'banner_display_options',
                    'type' => 'radio',
                    'description' => 'what pages should the banner show on?',
                    'std'  => 'all-pages',
                    'options' => array(
                        array( 'name' => 'All pages', 'value' => 'all-pages' ),
                        array( 'name' => 'Portfolio page only', 'value' => 'portfolio' ),
                        array( 'name' => 'Portfolio & post pages only', 'value' => 'portfolio-posts' ),
                    ),
                ),
            ),
        );
        return self::$theme_options;
    }

    /**
     * Make public the protected $key variable.
     * @since  0.1.0
     * @return string  Option key
     */
    public static function key() {
        return self::$key;
    }

}

// Get it started
$myprefix_Admin = new ct_theme_options_admin();
$myprefix_Admin->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function ct_get_option( $key = '' ) {
    return cmb_get_option( ct_theme_options_admin::key(), $key );
}