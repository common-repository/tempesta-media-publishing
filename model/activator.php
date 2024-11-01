<?php

/**
 * Fired during plugin activation
 * @link       https://tempestamedia.com
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model
 */

namespace TempestaMedia\Model;

/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Activator {

  /**
   * Short Description. (use period)
   * Long Description.
   * @since    1.0.0
   */
  public static function activate() {
    add_option('TempestaApiKey', Core::generateKey());
    add_option('TempestaDisableMetatags', '0');
  }
}
