<?php

/**
 * Fired during plugin deactivation
 * @link       https://tempestamedia.com
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model
 */

namespace TempestaMedia\Model;

/**
 * Fired during plugin deactivation.
 * This class defines all code necessary to run during the plugin's deactivation.
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Deactivator {

  /**
   * Short Description. (use period)
   * Long Description.
   * @since    1.0.0
   */
  public static function deactivate() {
    delete_option('TempestaApiKey');
    delete_option('TempestaDisableMetatags');
  }

}
