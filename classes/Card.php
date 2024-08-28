<?php
class Card {
    public $id;
    public $image;
    public $pairId;

    public function __construct($id, $image, $pairId) {
        $this->id = $id;
        $this->image = $image;
        $this->pairId = $pairId;
    }
}
