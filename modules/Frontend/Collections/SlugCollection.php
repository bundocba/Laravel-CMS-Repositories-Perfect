<?php

namespace Modules\Frontend\Collections;

class SlugCollection
{

    public $collection;
    protected $source;
    protected $slugs;

    public function __construct($source, $slugs)
    {
        $this->collection = collect();
        $this->source = $source;
        $this->slugs = $slugs;
    }

    public function findByUrl($url)
    {
        $filtered = $this->slugs->filter(function ($item) use ($url) {
            return $item->url == $url;
        });

        $item = $filtered->first();

        return $item;
    }

    public function findAncestors($current)
    {
        //var_dump($current);

        if ($current != null) {

            $slug = $this->findByUrl($current->url);
            if ($slug != null) {
                $current->slug = $slug->alias;
            }

            //echo $current->parent_id;
            //exit();

            $this->collection->put($current->id, $current);

            $filtered = $this->source->filter(function ($item) use ($current) {
                //echo $item->id . '=' . $current->parent_id . '<br/>';
                return $item->id == $current->parent_id;
            });

            $item = $filtered->first();

            //var_dump($item);

            if ($item != null) {

                $slug = $this->findByUrl($item->url);
                if ($slug != null) {
                    $item->alias = $slug->alias;
                }

                $this->collection->put($item->id, $item);

                $this->findAncestors($item);

            }
        }
    }

}
