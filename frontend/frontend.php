<?php

/**
 * The public-facing functionality of the plugin.
 * @link       https://tempestamedia.com
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/frontend
 */

namespace TempestaMedia\Frontend;

/**
 * The public-facing functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * @package    TempestaMedia
 * @subpackage TempestaMedia/admin
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Frontend {

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
   * @param string $plugin_name The name of the plugin.
   * @param string $version     The version of this plugin.
   *
   * @since    1.0.0
   */
  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Print meta tags on a HTML page
   * @since    1.0.0
   */
  public function add_meta_tags() {
    $title = get_post_meta(get_the_ID(), 'tm_meta_title', true);
    $description = get_post_meta(get_the_ID(), 'tm_meta_description', true);
    $keywords = get_post_meta(get_the_ID(), 'tm_meta_keywords', true);
    if(!empty($title)) {
      print '<meta name="title" content="' . esc_attr($title) . '">' . "\n";
    }
    if(!empty($keywords)) {
      print '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n";
    }
    if(!empty($description)) {
      print '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    }
  }
}
