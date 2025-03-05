<?php

namespace App;

/*
 * Class Name: Tailwind_Navwalker
 * Plugin Name: Tailwind Navwalker
 * Plugin URI:  https://github.com/ikamal7/tailwind-navwalker-wp
 * Description: A custom WordPress nav walker class to implement Tailwind navigation style in a custom theme using the WordPress built in menu manager.
 * Author: Edward McIntyre - @twittem, WP Bootstrap, William Patton - @pattonwebz
 * Version: 1.0
 * Author URI: https://github.com/ikamal7/tailwind-navwalker-wp
 * GitHub Plugin URI: https://github.com/ikamal7/tailwind-navwalker-wp
 * GitHub Branch: main
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

/* Check if Class Exists. */
if (!class_exists('Tailwind_Navwalker')) {
    /**
     * Tailwind_Navwalker class.
     *
     * @extends Walker_Nav_Menu
     */
    class Tailwind_Navwalker extends \Walker_Nav_Menu
    {

        /**
         * Starts the list before the elements are added.
         *
         * @since WP 3.0.0
         *
         * @see Walker_Nav_Menu::start_lvl()
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu menu-md dropdown-content w-56 p-2 bg-base-100 mt-0 rounded-box shadow-2xl ring-1 ring-black ring-opacity-5 z-20 text-gray-700\">\n";
        
    }
        

        /**
         * Starts the element output.
         *
         * @since WP 3.0.0
         * @since WP 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
         *
         * @see Walker_Nav_Menu::start_el()
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         * @param int      $id     Current item ID.
         */
        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
        
            // Add active class for current menu item
            if (in_array('current-menu-item', $classes)) {
                $classes[] = 'active';
            }
        
            if ($args->walker->has_children) {
                $classes[] = '';
            }
        
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
            // Dynamic tabindex based on depth
            $tabindex = 1 + ($depth * 10);
        
            $output .= $indent . '<li' . $id . $class_names . ' tabindex="' . esc_attr($tabindex) . '">';
        
            $atts = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target)     ? $item->target     : '';
            $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
            $atts['href']   = !empty($item->url)        ? $item->url        : '';
        
            $atts['tabindex'] = $tabindex; // Add tabindex to anchor tag
        
            // Add active class to the anchor tag as well
            if (in_array('current-menu-item', $classes)) {
                $atts['class'] = isset($atts['class']) ? $atts['class'] . ' active' : 'active';
            }
        
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
        
            $item_output = $args->before;
        
            if ($args->walker->has_children) {
                $item_output .= '<details><summary>';
            }
        
            $item_output .= '<a'. $attributes .'>';
            
            // Check if item has an icon class
            $icon_class = $this->get_menu_icon_class($classes);
            if ($icon_class) {
                $item_output .= '<i class="' . esc_attr($icon_class) . '"></i> ';
            }
            
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
        
            if ($args->walker->has_children) {
                $item_output .= '</summary>';
            }
        
            $item_output .= $args->after;
        
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
        

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        if ($args->walker->has_children) {
            $output .= "</details>";
        }
        $output .= "</li>\n";
    }

    private function get_menu_icon_class($classes)
    {
        $icon_class = '';
        foreach ($classes as $class) {
            if (strpos($class, 'icon-') === 0) {
                $icon_class = $class;
                break;
            }
        }
        return $icon_class;
    }

        /**
         * Traverse elements to create list from elements.
         *
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth. It is possible to set the
         * max depth to include all depths, see walk() method.
         *
         * This method should not be called directly, use the walk() method instead.
         *
         * @since WP 2.5.0
         *
         * @see Walker::start_lvl()
         *
         * @param object $element           Data object.
         * @param array  $children_elements List of elements to continue traversing (passed by reference).
         * @param int    $max_depth         Max depth to traverse.
         * @param int    $depth             Depth of current element.
         * @param array  $args              An array of arguments.
         * @param string $output            Used to append additional content (passed by reference).
         */
        public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {
            if (!$element) {
                return;
            }
        
            $id_field = $this->db_fields['id'];
            if (is_object($args[0])) {
                $args[0]->has_children = !empty($children_elements[$element->$id_field]);
            }
        
            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        /**
         * Menu Fallback
         * =============
         * If this function is assigned to the wp_nav_menu's fallback_cb variable
         * and a menu has not been assigned to the theme location in the WordPress
         * menu manager the function with display nothing to a non-logged in user,
         * and will add a link to the WordPress menu manager if logged in as an admin.
         *
         * @param array $args passed from the wp_nav_menu function.
         */
        public static function fallback($args)
        {
            if (current_user_can('edit_theme_options')) {

                /* Get Arguments. */
                $container       = $args['container'];
                $container_id    = $args['container_id'];
                $container_class = $args['container_class'];
                $menu_class      = $args['menu_class'];
                $menu_id         = $args['menu_id'];

                // initialize var to store fallback html.
                $fallback_output = '';

                if ($container) {
                    $fallback_output .= '<' . esc_attr($container);
                    if ($container_id) {
                        $fallback_output .= ' id="' . esc_attr($container_id) . '"';
                    }
                    if ($container_class) {
                        $fallback_output .= ' class="' . esc_attr($container_class) . '"';
                    }
                    $fallback_output .= '>';
                }
                $fallback_output .= '<ul';
                if ($menu_id) {
                    $fallback_output .= ' id="' . esc_attr($menu_id) . '"';
                }
                if ($menu_class) {
                    $fallback_output .= ' class="' . esc_attr($menu_class) . '"';
                }
                $fallback_output .= '>';
                $fallback_output .= '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '" title="' . esc_attr__('Add a menu', 'Tailwind-Navwalker') . '">' . esc_html__('Add a menu', 'Tailwind-Navwalker') . '</a></li>';
                $fallback_output .= '</ul>';
                if ($container) {
                    $fallback_output .= '</' . esc_attr($container) . '>';
                }

                // if $args has 'echo' key and it's true echo, otherwise return.
                if (array_key_exists('echo', $args) && $args['echo']) {
                    echo $fallback_output; // WPCS: XSS OK.
                } else {
                    return $fallback_output;
                }
            }
        }

        /**
         * Find any custom linkmod or icon classes and store in their holder
         * arrays then remove them from the main classes array.
         *
         * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
         * Supported iconsets: Font Awesome 4/5, Glypicons
         *
         * NOTE: This accepts the linkmod and icon arrays by reference.
         *
         * @since 4.0.0
         *
         * @param array   $classes         an array of classes currently assigned to the item.
         * @param array   $linkmod_classes an array to hold linkmod classes.
         * @param array   $icon_classes    an array to hold icon classes.
         * @param integer $depth           an integer holding current depth level.
         *
         * @return array  $classes         a maybe modified array of classnames.
         */
        private function seporate_linkmods_and_icons_from_classes($classes, &$linkmod_classes, &$icon_classes, $depth)
        {
            // Loop through $classes array to find linkmod or icon classes.
            foreach ($classes as $key => $class) {
                // If any special classes are found, store the class in it's
                // holder array and and unset the item from $classes.
                if (preg_match('/^disabled|^sr-only/i', $class)) {
                    // Test for .disabled or .sr-only classes.
                    $linkmod_classes[] = $class;
                    unset($classes[$key]);
                } elseif (preg_match('/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class) && $depth > 0) {
                    // Test for .dropdown-header or .dropdown-divider and a
                    // depth greater than 0 - IE inside a dropdown.
                    $linkmod_classes[] = $class;
                    unset($classes[$key]);
                } elseif (preg_match('/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class)) {
                    // Font Awesome.
                    $icon_classes[] = $class;
                    unset($classes[$key]);
                } elseif (preg_match('/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class)) {
                    // Glyphicons.
                    $icon_classes[] = $class;
                    unset($classes[$key]);
                }
            }

            return $classes;
        }

        /**
         * Return a string containing a linkmod type and update $atts array
         * accordingly depending on the decided.
         *
         * @since 4.0.0
         *
         * @param array $linkmod_classes array of any link modifier classes.
         *
         * @return string                empty for default, a linkmod type string otherwise.
         */
        private function get_linkmod_type($linkmod_classes = array())
        {
            $linkmod_type = '';
            // Loop through array of linkmod classes to handle their $atts.
            if (!empty($linkmod_classes)) {
                foreach ($linkmod_classes as $link_class) {
                    if (!empty($link_class)) {

                        // check for special class types and set a flag for them.
                        if ('dropdown-header' === $link_class) {
                            $linkmod_type = 'dropdown-header';
                        } elseif ('dropdown-divider' === $link_class) {
                            $linkmod_type = 'dropdown-divider';
                        } elseif ('dropdown-item-text' === $link_class) {
                            $linkmod_type = 'dropdown-item-text';
                        }
                    }
                }
            }
            return $linkmod_type;
        }

        /**
         * Update the attributes of a nav item depending on the limkmod classes.
         *
         * @since 4.0.0
         *
         * @param array $atts            array of atts for the current link in nav item.
         * @param array $linkmod_classes an array of classes that modify link or nav item behaviors or displays.
         *
         * @return array                 maybe updated array of attributes for item.
         */
        private function update_atts_for_linkmod_type($atts = array(), $linkmod_classes = array())
        {
            if (!empty($linkmod_classes)) {
                foreach ($linkmod_classes as $link_class) {
                    if (!empty($link_class)) {
                        // update $atts with a space and the extra classname...
                        // so long as it's not a sr-only class.
                        if ('sr-only' !== $link_class) {
                            $atts['class'] .= ' ' . esc_attr($link_class);
                        }
                        // check for special class types we need additional handling for.
                        if ('disabled' === $link_class) {
                            // Convert link to '#' and unset open targets.
                            $atts['href'] = '#';
                            unset($atts['target']);
                        } elseif ('dropdown-header' === $link_class || 'dropdown-divider' === $link_class || 'dropdown-item-text' === $link_class) {
                            // Store a type flag and unset href and target.
                            unset($atts['href']);
                            unset($atts['target']);
                        }
                    }
                }
            }
            return $atts;
        }

        /**
         * Wraps the passed text in a screen reader only class.
         *
         * @since 4.0.0
         *
         * @param string $text the string of text to be wrapped in a screen reader class.
         * @return string      the string wrapped in a span with the class.
         */
        private function wrap_for_screen_reader($text = '')
        {
            if ($text) {
                $text = '<span class="sr-only">' . $text . '</span>';
            }
            return $text;
        }

        /**
         * Returns the correct opening element and attributes for a linkmod.
         *
         * @since 4.0.0
         *
         * @param string $linkmod_type a sting containing a linkmod type flag.
         * @param string $attributes   a string of attributes to add to the element.
         *
         * @return string              a string with the openign tag for the element with attribibutes added.
         */
        private function linkmod_element_open($linkmod_type, $attributes = '')
        {
            $output = '';
            if ('dropdown-item-text' === $linkmod_type) {
                $output .= '<span class="dropdown-item-text"' . $attributes . '>';
            } elseif ('dropdown-header' === $linkmod_type) {
                // For a header use a span with the .h6 class instead of a real
                // header tag so that it doesn't confuse screen readers.
                $output .= '<span class="dropdown-header h6"' . $attributes . '>';
            } elseif ('dropdown-divider' === $linkmod_type) {
                // this is a divider.
                $output .= '<div class="dropdown-divider"' . $attributes . '>';
            }
            return $output;
        }

        /**
         * Return the correct closing tag for the linkmod element.
         *
         * @since 4.0.0
         *
         * @param string $linkmod_type a string containing a special linkmod type.
         *
         * @return string              a string with the closing tag for this linkmod type.
         */
        private function linkmod_element_close($linkmod_type)
        {
            $output = '';
            if ('dropdown-header' === $linkmod_type || 'dropdown-item-text' === $linkmod_type) {
                // For a header use a span with the .h6 class instead of a real
                // header tag so that it doesn't confuse screen readers.
                $output .= '</span>';
            } elseif ('dropdown-divider' === $linkmod_type) {
                // this is a divider.
                $output .= '</div>';
            }
            return $output;
        }
    }
}