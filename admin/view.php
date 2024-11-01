<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-03-19
 * Time: 22:22
 */

namespace TempestaMedia\Admin;

/**
 * The admin-specific view of the plugin.
 * Defines the view file.
 * @package    TempestaMedia
 * @subpackage TempestaMedia/admin/view
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class View {
  /**
   * Options page
   */
  static function options_page() {
    include 'view/options.php';
  }

  /**
   * Metatags box
   */
  static function metatags_box() {
    include 'view/metatags.php';
  }
}
