<?php

namespace Modules\Backend\Widgets;

class HTMLWidget
{

    protected $tag;

    public function __construct(TagCreator $tag)
    {
        $this->tag = $tag;
    }

    public function p($contents, $attributes = [])
    {
        return $this->tag->create('p', $contents, $attributes);
    }

    public function div($contents, $attributes = array())
    {
        return $this->tag->create('div', $contents, $attributes);
    }
}
