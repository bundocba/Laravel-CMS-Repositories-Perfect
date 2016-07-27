<?php

namespace Modules\Backend\Widgets;

class TagCreator
{

    public function create($tag, $contents, $attributes = array())
    {
        $attributes = \Html::attributes($attributes);

        return "<{$tag}{$attributes}>{$contents}</{$tag}>";
    }

}
