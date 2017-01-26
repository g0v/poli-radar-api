<?php

namespace Api\V2\Transformers;

use App\EventCategory;
use League\Fractal\TransformerAbstract;

class EventCategoryTransformer extends TransformerAbstract
{
    public function transform(EventCategory $category)
    {
        return [
            'id' => (int)$category->id,
            'name' => $category->name,
        ];
    }
}
