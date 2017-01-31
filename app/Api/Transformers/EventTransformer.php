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
        if (is_null($event->location)) return $this->null();
        return $this->item($event>location, new LocationTransformer);
    }
}
