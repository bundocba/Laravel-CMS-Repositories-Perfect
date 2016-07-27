<?php

namespace Modules\Frontend\Collections;

class MenuLinkCollection
{
    public $collection;
    protected $source;

    public function __construct($source)
    {
        $this->collection = collect();
        $this->source = $source;
    }
    
    public function findByUrl($url)
    {
        $filtered = $this->source->filter(function ($item) use ($url) {
            return $item->url == $url;
        });

        $item = $filtered->first();

        return $item;
    }
    
    public function findByControllerName($controllerName)
    {
        $filtered = $this->source->filter(function ($item) use ($controllerName) {
            return $item->controller == $controllerName;
        });

        $item = $filtered->first();

        return $item;
    }

    public function findAncestors($current)
    {
        $this->collection->put($current->id, $current);

        $filtered = $this->source->filter(function ($item) use ($current) {
            //echo $item->id . '=' . $current->parent_id . '<br/>';
            return $item->id == $current->parent_id;
        });

        $item = $filtered->first();

        if ($item != null) {
            
            $this->collection->put($item->id, $item);

            $this->findAncestors($item);

        }
    }

}
