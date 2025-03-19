<?php

namespace Imagewize\ImgMegaMenu;

class MenuFields
{
    /**
     * Register the menu fields.
     *
     * @return void
     */
    public function register()
    {
        add_action('wp_nav_menu_item_custom_fields', [$this, 'addCustomFields'], 10, 4);
        add_action('wp_update_nav_menu_item', [$this, 'saveCustomFields'], 10, 3);
        add_filter('wp_setup_nav_menu_item', [$this, 'setupMenuItem']);
    }

    /**
     * Add custom fields to menu item admin screen.
     *
     * @param int $item_id
     * @param object $item
     * @param int $depth
     * @param array $args
     * @return void
     */
    public function addCustomFields($item_id, $item, $depth, $args)
    {
        // Category field
        $category = get_post_meta($item_id, '_menu_item_category', true);
        ?>
        <div class="field-category description-wide" style="margin: 5px 0;">
            <label for="edit-menu-item-category-<?php echo $item_id; ?>">
                <?php _e('Category (for mega menu grouping)', 'img-mega-menu'); ?><br>
                <input type="text" id="edit-menu-item-category-<?php echo $item_id; ?>" 
                       class="widefat" name="menu-item-category[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($category); ?>">
                <span class="description"><?php _e('Group this menu item under a category in the megamenu (optional)', 'img-mega-menu'); ?></span>
            </label>
        </div>
        <?php

        // Description field
        $description = get_post_meta($item_id, '_menu_item_mega_description', true);
        ?>
        <div class="field-mega-description description-wide" style="margin: 5px 0;">
            <label for="edit-menu-item-mega-description-<?php echo $item_id; ?>">
                <?php _e('Description (for mega menu)', 'img-mega-menu'); ?><br>
                <textarea id="edit-menu-item-mega-description-<?php echo $item_id; ?>" 
                       class="widefat" name="menu-item-mega-description[<?php echo $item_id; ?>]" 
                       rows="3"><?php echo esc_textarea($description); ?></textarea>
                <span class="description"><?php _e('Short description to display under the menu item', 'img-mega-menu'); ?></span>
            </label>
        </div>
        <?php

        // Featured image field
        $featured_image = get_post_meta($item_id, '_menu_item_featured_image', true);
        ?>
        <div class="field-featured-image description-wide" style="margin: 5px 0;">
            <label for="edit-menu-item-featured-image-<?php echo $item_id; ?>">
                <?php _e('Featured Image URL (for mega menu)', 'img-mega-menu'); ?><br>
                <input type="text" id="edit-menu-item-featured-image-<?php echo $item_id; ?>" 
                       class="widefat" name="menu-item-featured-image[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($featured_image); ?>">
                <span class="description"><?php _e('Image URL to show in the megamenu (for parent items)', 'img-mega-menu'); ?></span>
            </label>
        </div>
        <?php

        // Featured text field
        $featured_text = get_post_meta($item_id, '_menu_item_featured_text', true);
        ?>
        <div class="field-featured-text description-wide" style="margin: 5px 0;">
            <label for="edit-menu-item-featured-text-<?php echo $item_id; ?>">
                <?php _e('Featured Text (for mega menu)', 'img-mega-menu'); ?><br>
                <textarea id="edit-menu-item-featured-text-<?php echo $item_id; ?>" 
                       class="widefat" name="menu-item-featured-text[<?php echo $item_id; ?>]" 
                       rows="4"><?php echo esc_textarea($featured_text); ?></textarea>
                <span class="description"><?php _e('Content to show in the featured section (for parent items)', 'img-mega-menu'); ?></span>
            </label>
        </div>
        <?php
    }

    /**
     * Save the custom field values.
     *
     * @param int $menu_id
     * @param int $menu_item_db_id
     * @param array $args
     * @return void
     */
    public function saveCustomFields($menu_id, $menu_item_db_id, $args)
    {
        // Save category
        if (isset($_POST['menu-item-category'][$menu_item_db_id])) {
            update_post_meta(
                $menu_item_db_id, 
                '_menu_item_category', 
                sanitize_text_field($_POST['menu-item-category'][$menu_item_db_id])
            );
        }

        // Save description
        if (isset($_POST['menu-item-mega-description'][$menu_item_db_id])) {
            update_post_meta(
                $menu_item_db_id, 
                '_menu_item_mega_description', 
                sanitize_textarea_field($_POST['menu-item-mega-description'][$menu_item_db_id])
            );
        }

        // Save featured image
        if (isset($_POST['menu-item-featured-image'][$menu_item_db_id])) {
            update_post_meta(
                $menu_item_db_id, 
                '_menu_item_featured_image', 
                esc_url_raw($_POST['menu-item-featured-image'][$menu_item_db_id])
            );
        }

        // Save featured text
        if (isset($_POST['menu-item-featured-text'][$menu_item_db_id])) {
            update_post_meta(
                $menu_item_db_id, 
                '_menu_item_featured_text', 
                wp_kses_post($_POST['menu-item-featured-text'][$menu_item_db_id])
            );
        }
    }

    /**
     * Add custom fields to menu item.
     *
     * @param object $menu_item
     * @return object
     */
    public function setupMenuItem($menu_item)
    {
        // Add our custom meta as properties of the menu item object
        $menu_item->category = get_post_meta($menu_item->ID, '_menu_item_category', true);
        $menu_item->description = get_post_meta($menu_item->ID, '_menu_item_mega_description', true);
        $menu_item->featured_image = get_post_meta($menu_item->ID, '_menu_item_featured_image', true);
        $menu_item->featured_text = get_post_meta($menu_item->ID, '_menu_item_featured_text', true);

        return $menu_item;
    }
}
