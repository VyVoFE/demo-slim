<?php
class Cat {
    public $name;
    public $age;
    public $color;
    
    public function __construct($reqBody){
		if($reqBody){
			$this->name     = $reqBody['name'];
			$this->age		= $reqBody['age'];
			$this->color	= $reqBody['color'];
		}
	}
}
?>