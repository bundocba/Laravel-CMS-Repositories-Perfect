<?php

namespace Modules\Backend\Widgets;

class Navigation
{
    public function __construct()
    {
    }

    function printMenuLinks($menuLinks, $prefix, $attributes = [])
    {
        $output = '';

        foreach ($menuLinks as $menuLink) {

            if ($menuLink->parent_id == null) {

                if ($menuLink->children_count == 0) {
                    if ($menuLink->url) {
                        $output .= '<li class="treeview' . ($menuLink->selected ? ' active' : '') . '"><a href="' . url($prefix . '' . $menuLink->url) . '"><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></a></li>' . PHP_EOL;
                    } else {
                        $output .= '<li class="treeview' . ($menuLink->selected ? ' active' : '') . '"><span><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></span></li>' . PHP_EOL;
                    }

                } else {
                    
                    if ($menuLink->url) {
                        $output .= '<li class="treeview' . ($menuLink->selected ? ' active' : '') . '"><a href="' . url($prefix . '' . $menuLink->url) . '"><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></a><ul class="treeview-menu">' . PHP_EOL;
                        $output .= $this->printSubMenuLinks($menuLinks, $menuLink->id, $prefix);
                        $output .= '</ul></li>' . PHP_EOL;
                    } else {
                        $output .= '<li class="treeview' . ($menuLink->selected ? ' active' : '') . '"><a><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></a><ul class="treeview-menu">' . PHP_EOL;
                        $output .= $this->printSubMenuLinks($menuLinks, $menuLink->id, $prefix);
                        $output .= '</ul></li>' . PHP_EOL;
                    }
                }
            }
        }

        echo $output;
    }

    function printSubMenuLinks($menuLinks, $parentId, $prefix, $attributes = [])
    {
        $output = '';

        foreach ($menuLinks as $menuLink) {

            if ($menuLink->parent_id == $parentId) {

                if ($menuLink->children_count == 0) {

                    if ($menuLink->url) {
                        $output .= '<li' . ($menuLink->selected ? ' class="active"' : '') . '><a href="' . url($prefix . '' . $menuLink->url) . '"><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></a></li>' . PHP_EOL;
                    } else {
                        $output .= '<li' . ($menuLink->selected ? ' class="active"' : '') . '><span><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></span></li>' . PHP_EOL;
                    }
                    
                } else {
                    $output .= '<li class="treeview' . ($menuLink->selected ? ' active' : '') . '"><a href="' . url($menuLink->url) . '"><i class="' . $menuLink->icon . '"></i> <span>' . trans($menuLink->title) . '</span></a><ul class="treeview-menu">' . PHP_EOL;
                    $output .= $this->printSubMenuLinks($menuLinks, $menuLink->id, $prefix);
                    $output .= '</ul></li>' . PHP_EOL;
                }
            }
        }

        return $output;
    }

}
