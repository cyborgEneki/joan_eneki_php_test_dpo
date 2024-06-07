<?php

class Instrument
{
    public $type;
    public $material;

    public function __construct($type, $material)
    {
        $this->type = $type;
        $this->material = $material;
    }

    public function displayDetails()
    {
        echo "This instrument is a " . $this->type . " made of " . $this->material . ".";
    }
}

$myInstrument = new Instrument("Violin", "Wood");

$myInstrument->displayDetails();
