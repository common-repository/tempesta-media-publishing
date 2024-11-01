<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-03-20
 * Time: 13:28
 */

namespace TempestaMedia\Model\Api;

use TempestaMedia\Model\Exception\ApiRuntimeException;

/**
 * Api listener.
 * @since      1.0.0
 * @package    TempestaMedia
 * @subpackage TempestaMedia/model/api
 * @author     Sharapov A. <alexander@sharapov.biz>
 */
class Action {
  public static $post_allowed_meta_keys = [
    'tm_meta_title',
    'tm_meta_description',
    'tm_meta_keywords'
  ];

  public static $allowed_mimes = [
    'image/jpeg',
    'image/gif',
    'image/png'
  ];

  /**
   * Verify token
   *
   * @param $token
   *
   * @return bool
   * @throws ApiRuntimeException
   */
  public static function verify($token) {
    $token = @base64_decode($token);
    $saved_token = get_option('TempestaApiKey');
    if(empty($saved_token) or empty($token)) {
      throw new ApiRuntimeException('No authentication token provided', Utility::API_CODE_UNAUTHORIZED);
    }
    if($token !== $saved_token) {
      throw new ApiRuntimeException('Wrong authentication token', Utility::API_CODE_UNAUTHORIZED);
    }

    return true;
  }

  /**
   * Programmatically publish a post
   *
   * @param array $inputPost
   *
   * @return int|\WP_Error
   */
  public static function publish(array $inputPost) {
    $new_post = [
      'post_title'    => sanitize_text_field($inputPost['title']),
      'post_content'  => wp_kses_post($inputPost['body']),
      'post_date'     => date('Y-m-d H:i:s'),
      'post_author'   => get_user_by('login', 'admin')->ID,
      'post_type'     => 'post',
      'post_category' => [0]
    ];

    return wp_insert_post($new_post);
  }

  /**
   * Programmatically save attachments to media library
   *
   * @param array $attachments
   *
   * @return array
   * @throws \TempestaMedia\Model\Exception\ApiRuntimeException
   */
  public static function attachments(array $attachments) {
    if((!$uploads = wp_get_upload_dir())) {
      throw new ApiRuntimeException('No upload dir found', Utility::API_CODE_PUBLISH_POST);
    }

    $o = [];
    foreach($attachments['tmp_name'] as $i => $attachment) {
      if($attachments['error'][$i] == 0) {
        if(in_array($attachments['type'][$i], self::$allowed_mimes)) {
          $fileName = wp_unique_filename($uploads['path'], sanitize_file_name($attachments['name'][$i]));
          @mkdir(dirname($uploads['path'] . '/' . $fileName), 0755, true);
          copy($attachment, $uploads['path'] . '/' . $fileName);
          $wp_filetype = wp_check_filetype($uploads['path'] . '/' . $fileName);
          $attachment = [
            'post_mime_type' => $wp_filetype['type'],
            'post_parent'    => 0,
            'post_title'     => preg_replace('/\.[^.]+$/', '', $fileName),
            'post_content'   => '',
            'post_status'    => 'inherit'
          ];
          // Insert attachment into the database
          $o[] = wp_insert_attachment($attachment, $uploads['path'] . '/' . $fileName);
        }
      }
    }

    return $o;
  }

  /**
   * Add/update meta tags for specific post
   *
   * @param $postId
   * @param array $metas
   *
   * @return array
   */
  public static function updateMetatags($postId, array $metas) {
    if(!empty($metas)) {
      foreach($metas as $metaKey => $metaValue) {
        if(in_array($metaKey, self::$post_allowed_meta_keys)) {
          $metaValue = sanitize_text_field($metaValue);
          if(!add_post_meta($postId, $metaKey, $metaValue, true)) {
            update_post_meta($postId, $metaKey, $metaValue);
          }
        } else {
          unset($metas[$metaKey]);
        }
      }
    }

    return $metas;
  }

  /**
   * Find first admin username
   * @return string
   */
  public static function findFirstAdminUsername() {
    return current(get_super_admins());
  }
}
