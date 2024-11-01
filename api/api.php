<?php

/**
 * The public-facing functionality of the plugin.
 * @link       https://tempestamedia.com
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/api
 */

namespace TempestaMedia\Api;

use TempestaMedia\Model\Api\Action;
use TempestaMedia\Model\Api\Utility;
use TempestaMedia\Model\Exception\ApiRuntimeException;

/**
 * The public-facing functionality of the plugin.
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * @package    TempestaMedia
 * @subpackage TempestaMedia/api
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Api {

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
   * Api listener
   * @return void
   * @since    1.0.0
   */
  public function api_listener() {
    if($action = $this->_get_request_parameter('tempesta_action') and !empty($action)) {
      try {
        $token = $this->_get_request_parameter('access_token');
        switch($action) {
          case 'publish' :
            Action::verify($token);
            $title = $this->_get_request_parameter('tm_title');
            $body = $this->_get_request_parameter('tm_body', false);
            $tm_meta_title = $this->_get_request_parameter('tm_meta_title');
            $tm_meta_description = $this->_get_request_parameter('tm_meta_description');
            $tm_meta_keywords = $this->_get_request_parameter('tm_meta_keywords');

            if(empty($title)) {
              throw new ApiRuntimeException('Missing article title', Utility::API_CODE_PUBLISH_POST);
            }

            if(!empty($_FILES['tm_files'])) {
              $attachments = Action::attachments($_FILES['tm_files']);
            } else {
              $attachments = null;
            }
            $postId = Action::publish([
                                        'title' => $title,
                                        'body'  => $body
                                      ]);

            if(!is_int($postId)) {
              throw new ApiRuntimeException('There is an error while publishing post', Utility::API_CODE_PUBLISH_POST);
            }

            $metaTags = Action::updateMetatags($postId, [
              'tm_meta_title'       => $tm_meta_title,
              'tm_meta_description' => $tm_meta_description,
              'tm_meta_keywords'    => $tm_meta_keywords
            ]);

            $args = [
              'success'     => true,
              'postID'      => $postId,
              'attachments' => $attachments,
              'metaTags'    => $metaTags
            ];
            break;
          case 'verify' :
            Action::verify($token);
            $args = [
              'success' => true
            ];
            break;
          default:
            throw new ApiRuntimeException('Unknown request', Utility::API_CODE_UNKNOWN_REQUEST);
        }
        Utility::output_api_response($args);
      } catch (ApiRuntimeException $e) {
        Utility::output_api_response([
                                       'success' => false,
                                       'message' => $e->getMessage()
                                     ]);
      }
    }
  }

  /**
   * Get request parameter
   *
   * @param $key
   * @param bool $stripTags
   *
   * @return string|null
   * @since    1.0.0
   */
  private function _get_request_parameter($key, $stripTags = true) {
    // If not request set
    if(!isset($_REQUEST[$key]) || empty($_REQUEST[$key])) {
      return null;
    }

    if($stripTags == false) {
      return $_REQUEST[$key];
    }

    // Set so process it
    return strip_tags((string)wp_unslash($_REQUEST[$key]));
  }
}
