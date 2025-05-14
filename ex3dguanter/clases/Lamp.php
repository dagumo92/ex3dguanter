<?php
class Lamp {
    private $id, $name, $isOn, $model, $wattage, $zone;

    public function __construct($id, $name, $isOn, $model, $wattage, $zone) {
        $this->id = $id;
        $this->name = $name;
        $this->isOn = $isOn;
        $this->model = $model;
        $this->wattage = $wattage;
        $this->zone = $zone;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function isOn() { return $this->isOn; }
    public function getModel() { return $this->model; }
    public function getWattage() { return $this->wattage; }
    public function getZone() { return $this->zone; }
}
