<?php 

namespace Model;


class Led extends ActiveRecord{
    protected static $tabla = 'leds';
    protected static $columnasDB = ['active', 'brightness'];

    public $active;
    public $brightness;
}