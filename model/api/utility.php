<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-03-20
 * Time: 13:28
 */

namespace TempestaMedia\Model\Api;

/**
 * Api utilities.
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model/api
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Utility {
  const API_CODE_UNKNOWN_REQUEST = 405;
  const API_CODE_PUBLISH_POST = 500;
  const API_CODE_UNAUTHORIZED = 401;
  const API_CODE_ERROR = 500;

  static function output_api_response($args) {
    //Send response
    echo json_encode($args);
    exit(0);
  }
}
