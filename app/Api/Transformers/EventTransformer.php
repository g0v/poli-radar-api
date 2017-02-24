<?php

namespace Api\Transformers;

use App\Event;
use Carbon\Carbon;

class EventTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'place',
        'persons',
        'categories',
    ];

    protected $defaultIncludes = [
        'media',
    ];

    public function transform(Event $event)
    {
        return [
            'id' => (int) $event->id,
            'date' => $this->dateFormat($event->date),
            'start' => $event->start,
            'end' => $event->end,
            'name' => $event->name,
            'link' => $event->link,
            'description' => $event->description,
        ];
    }

    public function includeCategories(Event $event)
    {
        return $this->collection($event->categories, new EventCategoryTransformer);
    }

    public function includePersons(Event $event)
    {
        return $this->collection($event->persons, new PersonTransformer);
    }

    public function includeMedia(Event $event)
    {
        if ($event->media) return $this->item($event->media, new MediaTransformer);
    }

    public function includePlace(Event $event)
    {
        $place = $event->place;
        if (is_null($place)) return $this->null();
        $place_type = $event->place_type;
        switch ($place_type) {
        case 'App\Location':
            return $this->item($place, new LocationTransformer);
        case 'App\Region':
            return $this->item($place, new RegionTransformer);
        }
    }
}
