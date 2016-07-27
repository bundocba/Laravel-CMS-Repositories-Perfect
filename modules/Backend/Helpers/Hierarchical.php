<?php

namespace Modules\Backend\Helpers;

class Hierarchical
{
    public $collection;
    protected $source;
    //protected $offset;
    //protected $limit;

    public function __construct($source)
    {
        $this->collection = collect();
        $this->source = $source;
    }

    public function build()
    {
        $this->getChildren(null, 0);
    }

    protected function getChildren($parent, $depth)
    {

        if ($parent != null) {
            $parentId = $parent->id;
            $filtered = $this->source->filter(function ($item) use ($parentId) {
                 return $item->parent_id == $parentId;
            });
        } else {
            $filtered = $this->source->filter(function ($item) {
                return $item->parent_id == null;
            });
        }

        $items = $filtered->all();

        if ($parent != null) {
            $parent->children_count = count($items);
        }

        foreach ($items as $item) {

            $item->depth = $depth;

            $this->collection->put($item->id, $item);

            $this->getChildren($item, $depth + 1);

        }
    }
    
}