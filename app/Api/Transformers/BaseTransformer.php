<?php

namespace Api\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use Carbon\Carbon;


class NullTransformer extends TransformerAbstract
{
  public function transform()
  {
    return [];
  }
}

class BaseTransformer extends TransformerAbstract
{

  public function dateFormat($source)
  {
    if (!isset($source)) return null;

    $date = new Carbon($source);
    return $date->format('Y-m-d');
  }

  public function null()
  {
    return $this->item(null, new NullTransformer);
  }
}
