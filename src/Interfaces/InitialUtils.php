<?php
namespace DoTravel\GoldenTour\Interfaces;

class InitialUtils
{
    protected function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
