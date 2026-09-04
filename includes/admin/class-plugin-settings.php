<?php
/**
 * Plugin settings.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PC_Plugin_Settings' ) ) {

 /**
  * Plugin settings.
  */
 class PC_Plugin_Settings {

  /**
   * Option name.
   * @var string
   */
  private const OPTION_NAME = 'pc_plugin_settings';

  // Constructor.

  public function __construct() {

   add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

   add_action('admin_init',  array( $this, 'register_settings' ) );
   
   add_filter(  'plugin_action_links_' . plugin_basename( PC_PLUGIN_FILE ),
    array( $this, 'add_settings_link' ) );
  }

  /**
 * Add settings link to plugin action links.
 *
 * @param array $links Plugin action links.
 * @return array
 */
public function add_settings_link( array $links ): array {

    $settings_url = menu_page_url(
        'psychology-courses-settings',
        false
    );

    $links[] = sprintf(
        '<a href="%s">%s</a>',
        esc_url( $settings_url ),
        esc_html__( 'Settings', 'psychology-courses' )
    );

    return $links;
  }
  /**
   * Add settings page.
   *
   * @return void
   */
  public function add_settings_page(): void {

   add_options_page(
    __( 'Psychology Courses', 'psychology-courses' ),
    __( 'Psychology Courses', 'psychology-courses' ),
    'manage_options',
    'psychology-courses-settings',
    array( $this, 'render_settings_page' )
   );

  }

  /**
   * Register settings.
   * @return void
   */
  public function register_settings(): void {

   register_setting(
    'pc_plugin_settings_group',
    self::OPTION_NAME,
    array(
     'sanitize_callback' => array(
      $this,
      'sanitize_settings',
     ),
    )
   );

   add_settings_section(
    'pc_general_settings',
    __( 'Main Settings', 'psychology-courses' ),
    '__return_false',
    'psychology-courses-settings'
   );

   add_settings_field(
    'pc_cf7_form_id',
    __( 'ID форми Contact Form 7', 'psychology-courses' ),
    array( $this, 'render_cf7_field' ),
    'psychology-courses-settings',
    'pc_general_settings'
   );

   add_settings_section(
    'pc_shortcodes',
    __( 'Shortcodes', 'psychology-courses' ),
    '__return_false',
    'psychology-courses-settings'
   );

   add_settings_field(
    'pc_course_shortcode',
    __( 'Courses', 'psychology-courses' ),
    array( $this, 'render_course_shortcode' ),
    'psychology-courses-settings',
    'pc_shortcodes'
   );

   add_settings_field(
    'pc_teacher_shortcode',
    __( 'Teachers', 'psychology-courses' ),
    array( $this, 'render_teacher_shortcode' ),
    'psychology-courses-settings',
    'pc_shortcodes'
   );

  }

  /**
   * Sanitize settings.
   * @param array $input Settings.
   * @return array
   */
/**
 * Sanitize settings.
 *
 * @param mixed $input Settings.
 * @return array
 */
public function sanitize_settings( $input ): array {

   if ( ! is_array( $input ) ) {
      return array(
         'cf7_form_id' => '',
      );
   }

   return array(
      'cf7_form_id' => isset( $input['cf7_form_id'] ) ? 
      sanitize_text_field( $input['cf7_form_id'] ) : '', );
}

/**
 * Render CF7 field.
 * @return void
 */
public function render_cf7_field(): void {

   $options = get_option( self::OPTION_NAME, array() );

   $form_id = isset( $options['cf7_form_id'] ) ? (string) $options['cf7_form_id'] : '';
   ?>

   <input
    type="text" class="regular-text"
    name="<?php echo esc_attr( self::OPTION_NAME ); ?>[cf7_form_id]"
    value="<?php echo esc_attr( $form_id ); ?>">

   <p class="description">
    <?php
    esc_html_e('ID форми Contact Form 7, яка використовується для запису на курс.',
     'psychology-courses');
    ?>
   </p>

   <?php
}

  /**
   * Render course shortcode.
   * @return void
   */
  public function render_course_shortcode(): void {
   $this->render_copy_field('[course_cards ids="ID1,ID2,ID3"]' );
  }

  /**
   * Render teacher shortcode.
   *
   * @return void
   */
  public function render_teacher_shortcode(): void {
   $this->render_copy_field('[teacher_slider ids="ID1,ID2,ID3"]');
  }

  /**
   * Render copy field.
   * @param string $shortcode Shortcode.
   * @return void
   */
  private function render_copy_field( string $shortcode ): void {
   ?>

   <div class="pc-copy-field">

    <input type="text"
     value="<?php echo esc_attr( $shortcode ); ?>"
     readonly class="regular-text">

    <button type="button" class="button pc-copy-shortcode"
    >
     <?php esc_html_e( 'Copy', 'psychology-courses' ); ?>
    </button>

   </div>

   <?php
  }
  /**
   * Render settings page.
   * @return void
   */
  public function render_settings_page(): void {
   ?>

   <div class="wrap">

    <h1>
     <?php
     esc_html_e(
      'Psychology Courses — налаштування',
      'psychology-courses'
     );
     ?>
    </h1>

    <form method="post" action="options.php">

     <?php
     settings_fields( 'pc_plugin_settings_group' );

     do_settings_sections(
      'psychology-courses-settings'
     );

     submit_button();
     ?>

    </form>

   </div>

   <?php
  }
 }
}