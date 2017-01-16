<?php

namespace Api\Transformers;

use App\Event;
use Carbon\Carbon;

class EventTransformer extends BaseTransformer
{
    protected $availableIncludes = [
  		'location',
      'person',
    ];

    protected $defaultIncludes = [
      'categories',
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

    public function includePerson(Event $event)
    {
        return $this->item($event->person, new PersonTransformer);
    }

    public function includeMedia(Event $event)
    {
        if ($event->media) return $this->item($event->media, new MediaTransformer);
    }
}
