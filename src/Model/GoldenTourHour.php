<?php
namespace  DoTravel\GoldenTour\Model;

use DoTravel\GoldenTour\Interfaces\InitialUtils;

class GoldenTourHour extends InitialUtils
{
    public $id;
    public $hour;

    public $block;

    public $noblock;

    public $available;


    public function __construct(
        $data,
        $id = null,
        $hour = null,
        $block = null,
        $noblock = null,
        $available = null
    ) {
        parent::__construct($data);
        if (!isset($data)) {
            $this->id = $id;
            $this->hour = $hour;
            $this->block = $block;
            $this->noblock = $min;
            $this->available = $name;
        }
    }
}
