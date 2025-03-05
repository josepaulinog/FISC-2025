<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Navigation extends Component
{
    public $items;

    public function __construct($name = 'primary_navigation')
    {
        $this->items = $this->getMenuItems($name);
    }

    protected function getMenuItems($name)
    {
        if (!has_nav_menu($name)) {
            return [];
        }

        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$name]);
        $items = wp_get_nav_menu_items($menu->term_id);

        return $this->buildMenuTree($items);
    }

    protected function buildMenuTree($items, $parentId = 0)
    {
        $branch = [];

        foreach ($items as $item) {
            if ($item->menu_item_parent == $parentId) {
                $children = $this->buildMenuTree($items, $item->ID);
                if ($children) {
                    $item->children = $children;
                }
                $branch[$item->ID] = $item;
                unset($item);
            }
        }

        return $branch;
    }

    public function render()
    {
        return $this->view('components.navigation');
    }
}