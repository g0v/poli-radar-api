<?php

namespace Api\Transformers;

use App\PostClassification;

class PostClassificationTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'event_category',
        'posts',
    ];

    public function transform(PostClassification $pCat)
    {
        return [
            'id' => (int) $pCat->id,
            'name' => $pCat->name,
        ];
    }

    public function includePosts(PostClassification $pCat)
    {
        return $this->collection($pCat->posts, new PostTransformer);
    }

    public function includeEventCategory(PostClassification $pCat)
    {
        return $this->item($pCat->event_category, new EventCategoryTransformer);
    }
}
