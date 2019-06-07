<?php

namespace DoTravel\GoldenTour\Model;

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
    )
    {
        parent::__construct($data);

        if (!isset($data)) {
            $this->id = $id;
            $this->hour = $hour;
            $this->block = $block;
            $this->noblock = $noblock;
            $this->available = $available;
        }
        $this->hour = $this->formatHour($this->hour);
    }

    protected function formatHour($hour)
    {
        if (isset(\DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$hour])) {
            $result = "00:00";
        } else {
            switch ($hour) {
                case "Full Day":
                case "Half Day":

                    $result = "00:00";
                    break;
                default:
                    $result = trim(date("H:i", strtotime($hour)));
                    break;
            }
        }
        return $result;

    }
}
