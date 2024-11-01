<?php

/**
 * The admin-specific functionality of the plugin.
 * @link       https://tempestamedia.com
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/admin
 */

namespace TempestaMedia\Admin;

use TempestaMedia\Model\Api\Action;
use TempestaMedia\Model\Exception\ConfigException;

/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @package    TempestaMedia
 * @subpackage TempestaMedia/admin
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Admin {

  /**
   * The ID of this plugin.
   * @since    1.0.0
   * @access   private
   * @var      string $plugin_name The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   * @since    1.0.0
   * @access   private
   * @var      string $version The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @param string $plugin_name The name of this plugin.
   * @param string $version     The version of this plugin.
   *
   * @since    1.0.0
   */
  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  /**
   * Register the stylesheets for the admin area.
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     * An instance of this class should be passed to the run() function
     * defined in TempestaMedia_Loader as all of the hooks are defined
     * in that particular class.
     * The plugin loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin.css', [], $this->version, 'all');

  }

  /**
   * Register the JavaScript for the admin area.
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     * An instance of this class should be passed to the run() function
     * defined in TempestaMedia_Loader as all of the hooks are defined
     * in that particular class.
     * The plugin loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script($this->plugin_name,
                      plugin_dir_url(__FILE__) . 'js/admin.js',
                      ['jquery'],
                      $this->version,
                      false
    );
    wp_localize_script($this->plugin_name, 'ajax_var', [
      'url'   => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('tm-ajax-nonce')
    ]);
  }

  /**
   * Add Settings link to plugins area
   *
   * @param array $links Links array in which we would prepend our link
   * @param string $file Current plugin basename
   *
   * @return array Processed links
   * @since    1.0.0
   */
  public function action_links($links, $file) {
    // Return normal links if not bbPress
    if((false !== strpos(plugin_basename($file), $this->plugin_name))) {
      // New links to merge into existing links
      $new_links = [];

      // Settings page link
      $new_links['settings'] = '<a href="' . esc_url(add_query_arg(['page' => 'tempesta-media'], admin_url('options-general.php'))) . '">' . esc_html__('Settings', 'tempesta-media') . '</a>';

      // Add a few links to the existing links array
      return array_merge($links, $new_links);
    }

    return $links;
  }

  /**
   * Add options page
   * @return void
   */
  public function action_options_page() {
    add_options_page(
      'Tempesta Media Publishing',
      'Tempesta Media',
      'manage_options',
      $this->plugin_name,
      [View::class, 'options_page']);
  }

  /**
   * Register plugin configuration options
   * @return void
   */
  public function register_options() {
    register_setting('tempesta-group', 'TempestaApiKey');
    register_setting('tempesta-group', 'TempestaDisableMetatags');
  }

  /**
   * Print meta box
   */
  public function post_meta_box() {
    add_meta_box('tm_metatags', __('Tempesta Media imported meta tags', 'tempesta-media'), [View::class, 'metatags_box'], 'post');
  }

  /**
   * Save meta box data
   *
   * @param $post_id
   *
   * @throws ConfigException
   */
  function post_meta_box_save($post_id) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;
    if($parent_id = wp_is_post_revision($post_id)) {
      $post_id = $parent_id;
    }
    Action::updateMetatags($post_id, $_POST);
  }

  function save_config() {
    if(!wp_verify_nonce($_POST['nonce'], 'tm-ajax-nonce') or !current_user_can('manage_options')) {
      wp_die('ERR');
    }

    update_option('TempestaApiKey', sanitize_text_field($_POST['TempestaApiKey']));

    if(!isset($_POST['TempestaDisableMetatags']) or $_POST['TempestaDisableMetatags'] == 'false') {
      update_option('TempestaDisableMetatags', '0');
    } else {
      update_option('TempestaDisableMetatags', '1');
    }
    wp_die('OK');
  }
}
