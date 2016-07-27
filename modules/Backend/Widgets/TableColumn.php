<?php

namespace Modules\Backend\Widgets;

class TableColumn
{
    public function column($text, $column)
    {
        $html = '';

        $sortBy = \Request::query('sort_by', '');
        $sortDirection = \Request::query('sort_direction', 'asc');
        $url  = \Request::fullUrl();
        $sortUrl = '';

        $inputs = \Input::except('sort_by', 'sort_direction');
        $newUrl = \Request::url();
        $queryString = http_build_query($inputs);
        $newUrl .= '' . ($queryString != '' ? '?' . $queryString : '');
        $newUrl = strpos($newUrl, '?') ? $newUrl : $newUrl . '?';

        if ($column == $sortBy) {

            if (strtolower($sortDirection) == 'desc') {
                $newUrl .= '&sort_by=' . $sortBy . '&sort_direction=asc';
                $html = '<a href="' . $newUrl . '">' . $text . '</a> <i class="fa fa-fw fa-sort-desc"></i>';
            } else {
                $newUrl .= '&sort_by=' . $sortBy . '&sort_direction=desc';
                $html = '<a href="' . $newUrl . '">' . $text . '</a> <i class="fa fa-fw fa-sort-asc"></i>';
            }

        } else {
            $newUrl .= '&sort_by=' . $column . '&sort_direction=asc';
            $html = '<a href="' . $newUrl . '">' . $text . '</a>';
        }

        return $html;
    }

}
