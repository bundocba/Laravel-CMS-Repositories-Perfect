<?php

namespace Modules\Frontend\Widgets;

class Navigation
{
    public function __construct()
    {
    }

    function printMenuLinks($menuLinks, $attributes = [])
    {

        $index = 0;
        $output = '';

        foreach ($menuLinks as $menuLink) {

            if ($menuLink->parent_id == null) {

//                if ($menuLink->content_type_id != 3) {
//                    $output .= '<li role="presentation"' . ($index == 0 ? ' class="active"' : '') . '><a href="#' . $menuLink->id . '" role="tab" data-toggle="tab">' . $menuLink->name . '</a></li>' . PHP_EOL;
//                } else {
//                    $output .= '<li role="presentation"' . ($index == 0 ? ' class="active"' : '') . '><a href="' . $menuLink->url . '" target="' . $menuLink->target . '">' . $menuLink->name . '</a></li>' . PHP_EOL;
//                }
                if ($menuLink->children_count == 0) {

                    $output .= '<li role="presentation"' . ($index == 0 ? ' class="active"' : '') . '><a href="#' . $menuLink->id . '" role="tab" data-toggle="tab">' . $menuLink->name . '</a></li>' . PHP_EOL;

                    //$output .= $this->printSubContent($menuLinks, $menuLink->id);

//                    if ($menuLink->type == 2) {
//                        $output .= '<li><a href="' . $menuLink->url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '">' . $menuLink->name . '</a></li>' . PHP_EOL;
//                    } else {
//                        $output .= '<li><a href="' . $menuLink->full_url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '">' . $menuLink->name . '</a></li>' . PHP_EOL;
//                    }

                } else {

                    //$output .= '<li role="presentation"' . ($index == 0 ? ' class="active"' : '') . '><a href="#' . $menuLink->id . '" role="tab" data-toggle="tab">' . $menuLink->name . '</a></li>' . PHP_EOL;


                    $output .= '<li class="dropdown">' . PHP_EOL;
                    $output .= '<a href="' . $menuLink->full_url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menuLink->name . '<span class="caret"></span></a>' . PHP_EOL;
                    $output .= '<ul class="dropdown-menu">' . PHP_EOL;
                    $output .= $this->printSubMenuLinks($menuLinks, $menuLink->id);
                    $output .= '</ul>' . PHP_EOL;
                    $output .= '</li>' . PHP_EOL;
                }

                $index++;
            }
        }

        echo $output;
    }

    function printSubMenuLinks($menuLinks, $parentId, $attributes = [])
    {

        $output = '';

        foreach ($menuLinks as $menuLink) {

            if ($menuLink->parent_id == $parentId) {

                if ($menuLink->children_count == 0) {
                    if ($menuLink->type == 2) {
                        $output .= '<li><a href="' . $menuLink->url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '">' . $menuLink->name . '</a></li>' . PHP_EOL;
                    } else {
                        $output .= '<li><a href="' . $menuLink->full_url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '>' . $menuLink->name . '</a></li>' . PHP_EOL;
                    }
                } else {

                    $output .= '<li class="dropdown-submenu"><a href="' . $menuLink->full_url . '"' . ($menuLink->target == '_blank' ? ' target=_"blank"' : '') . '">' . $menuLink->name . '<span class=""></span></a>' . PHP_EOL;
                    $output .= '<ul class="dropdown-menu">' . PHP_EOL;
                    $output .= $this->printSubMenuLinks($menuLinks, $menuLink->id);
                    $output .= '</ul>' . PHP_EOL;
                    $output .= '</li>' . PHP_EOL;

                }
            }
        }

        return $output;
    }

//    function printSubContent($menuLinks, $parentId, $attributes = []) {
//
//    }
}
