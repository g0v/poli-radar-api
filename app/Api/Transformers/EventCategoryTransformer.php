<?php

namespace Api\Transformers;

use App\EventCategory;

class EventCategoryTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'parent',
        'children',
    ];

    public function transform(EventCategory $eCat)
    {
        return [
            'id' => (int) $eCat->id,
            'name' => $eCat->name,
        ];
    }

    public function includeParent(EventCategory $eCat)
    {
        $parent = $eCat->parent()->first();
        if (is_null($parent)) {
            return $this->null();
        }
        return $this->item($parent, new EventCategoryTransformer);
    }

    public function includeChildren(EventCategory $eCat)
    {
        $children = $eCat->children()->get();
        if ($children->count() > 0) {
            return $this->collection($children, new EventCategoryTransformer);
        }
        return $this->null();
    }
}
