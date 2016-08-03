<?php

namespace Api\V2\Transformers;

use App\Event;
use League\Fractal;

use Api\V2\Transformers\PoliticianTransformer;
use Api\V2\Transformers\EventCategoryTransformer;
use Api\V2\Transformers\LocationTransformer;

class EventTransformer extends Fractal\TransformerAbstract
{
	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
		'politicians',
		'categories',
        'location',
    ];

	public function transform(Event $event)
	{
		$fractal = new Fractal\Manager();
		if (isset($_GET['include'])) {
			$fractal->parseIncludes($_GET['include']);
		};

        return [
            'id' => $event->id,
            'name' => $event->name,
            'date' => $event->date,
            'start' => $event->start,
            'end' => $event->end,
        ];
	}

	public function includeCategories(Event $event)
	{
		$categories = $event
			->categories()
			->get();

		return $this->collection($categories, new EventCategoryTransformer);
	}

	public function includePoliticians(Event $event)
	{
		$politicians = $event
			->politicians()
			->get();

		return $this->collection($politicians, new PoliticianTransformer);
	}

	public function includeLocation(Event $event)
	{
		$location = $event
			->location()
			->first();

		return $this->item($location, new LocationTransformer);
	}
}
