<?php
namespace  DoTravel\GoldenTour\Model;

use DoTravel\GoldenTour\Interfaces\InitialUtils;

class GoldenTourPrice extends InitialUtils
{
    public $id;

    public $max;

    public $min;

    public $name;

    public $name_nospace;

    public $order;

    public $price;

    public $tag;

    public function __construct(
        $data,
        $id = null,
        $max = null,
        $min = null,
        $name = null,
        $name_nospace = null,
        $order = null,
        $price = null,
        $tag = null
    ) {
        parent::__construct($data);
        if (!isset($data)) {
            $this->id = $id;
            $this->max = $max;
            $this->min = $min;
            $this->name = $name;
            $this->name_nospace = $name_nospace;
            $this->order = $order;
            $this->price = $price;
            $this->tag = $tag;
        }
    }
}
