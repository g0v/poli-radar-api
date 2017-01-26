<?php

namespace Api\Transformers;

use App\Media;

class MediaTransformer extends BaseTransformer
{
    public function transform(Media $media)
    {
        return [
            'id' => (int) $media->id,
            'value' => url($media->value),
        ];
    }
}
