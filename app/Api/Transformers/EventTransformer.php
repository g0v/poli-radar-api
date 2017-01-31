<?php

namespace Api\Transformers;

use App\Event;
use Carbon\Carbon;

class EventTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'location',
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

    public function includeLocation(Event $event)
    {
        $location = $event->location;
        if (is_null($location)) return $this->null();
        $location_type = $event->location_type;
        switch ($location_type) {
        case 'App\Location':
            return $this->item($location, new LocationTransformer);
        case 'App\Region':
            return $this->item($location, new RegionTransformer);
        }
    }
}
