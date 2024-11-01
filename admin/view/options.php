<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-03-19
 * Time: 22:23
 */

use TempestaMedia\Model\Core;

?>
<div class="wrap">
  <h2><?php esc_html_e('Tempesta Media Publishing', 'tempesta-media') ?></h2>
  <form id="FormTempestaMediaOptions" action="options.php" method="post">
    <div class="tempesta-wrapper">
      <table class="form-table">
        <tbody>
        <tr>
          <th scope="row"><label for="TempestaApiKey"><?php esc_attr_e('API Key', 'tempesta-media'); ?></label></th>
          <td>
            <span id="tm_copy_status"><?php esc_attr_e('copied to clipboard', 'tempesta-media'); ?></span>
            <input type="text" name="TempestaApiKey"
                   value="<?php echo esc_attr(get_option('TempestaApiKey')); ?>"
                   readonly onclick="copyTempestaApiKey(this);" />
            <button href="#" name="getNewKey" class="button-primary"
                    data-key-prefix="<?php print Core::getKeyPrefix() ?>"
                    data-key-suffix="<?php print Core::getKeySuffix(); ?>">
              <?php esc_attr_e('Generate new', 'tempesta-media'); ?>
            </button>
            <span class="message" id="status-apikey"><?php esc_attr_e('Saved', 'tempesta-media'); ?></span>
            <p class="description"><?php esc_attr_e('Please user this key on the "Integrations" section of your Tempesta Media account to enable integration feature.', 'tempesta-media'); ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="blogdescription">Post meta tags</label></th>
          <td>
            <label><input type="checkbox" name="TempestaDisableMetatags"
                          value="1" <?php print checked(get_option('TempestaDisableMetatags') == '1'); ?> />
              <?php esc_attr_e('Disable meta tags publishing', 'tempesta-media'); ?></label><span class="message" id="status-metatags"><?php esc_attr_e('Saved', 'tempesta-media'); ?></span>
            <p class="description"><?php esc_attr_e('Please check this box if you have another plugin to manage meta tags. Please remember: you still be able to view meta tags imported from Tempesta Media and use them in external plugin.', 'tempesta-media'); ?></p>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>
