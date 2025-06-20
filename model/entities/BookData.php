<?php
class BookData {
    public $id;
    public $name;
    public $author;
    public $year;
    public $price;
    public $description;
    public $image_url;

    public function __construct($id, $name, $author, $year, $price, $description, $image_url = null) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->year = $year;
        $this->price = $price;
        $this->description = $description;
        $this->image_url = $image_url;
    }
}
