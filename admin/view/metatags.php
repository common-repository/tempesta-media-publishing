<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-03-19
 * Time: 22:23
 */
?>
<div class="tempesta-wrapper">
  <p class="tm-metabox-description">
    <?php if(false == get_option('TempestaDisableMetatags')) {
      esc_attr_e('The following meta tags were imported along with the article from your Tempesta 
    Media account', 'tempesta-media');
      print ' <b>';
      esc_attr_e('and will be published', 'tempesta-media');
      print '</b> ';
      esc_attr_e('in the head section for SEO purposes.', 'tempesta-media');
      $metaTagReadonly = '';
    } else {
      esc_attr_e('The following meta tags were imported along with the article from your Tempesta 
    Media account,', 'tempesta-media');
      print ' <b>';
      esc_attr_e('but won\'t be published,', 'tempesta-media');
      print '</b> ';
      esc_attr_e('because meta tags are managing by another plugin.', 'tempesta-media');
      $metaTagReadonly = 'readonly';
    } ?>
  </p>
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row"><label for="tm_meta_title"><?php esc_attr_e('Title', 'tempesta-media'); ?></label></th>
        <td>
          <input id="tm_meta_title" type="text" name="tm_meta_title"
                 value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'tm_meta_title', true)); ?>" <?php echo
          $metaTagReadonly; ?> />
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="tm_meta_keywords"><?php esc_attr_e('Keywords', 'tempesta-media'); ?></label></th>
        <td>
          <textarea id="tm_meta_keywords"
                    name="tm_meta_keywords" <?php echo $metaTagReadonly; ?>><?php echo esc_attr(get_post_meta(get_the_ID(), 'tm_meta_keywords', true)); ?></textarea>
        </td>
      </tr>
      <tr>
        <th scope="row"><label
              for="tm_meta_description"><?php esc_attr_e('Description', 'tempesta-media'); ?></label></th>
        <td>
          <textarea id="tm_meta_description"
                    name="tm_meta_description" <?php echo $metaTagReadonly; ?>><?php echo esc_attr(get_post_meta(get_the_ID(),
                                                                                                                 'tm_meta_description', true)); ?></textarea>
        </td>
      </tr>
    </tbody>
  </table>
</div>
