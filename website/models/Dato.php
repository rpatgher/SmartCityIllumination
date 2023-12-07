<?php 

namespace Model;


class Dato extends ActiveRecord{
    protected static $tabla = 'datos';
    protected static $columnasDB = ['led', 'current_mA', 'power_mW', 'voltage_V', 'time'];

    public $led;
    public $current_mA;
    public $power_mW;
    public $voltage_V;
    public $time;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->led = $args['led'] ?? '';
        $this->current_mA = $args['current_mA'] ?? '';
        $this->power_mW = $args['power_mW'] ?? '';
        $this->voltage_V = $args['voltage_V'] ?? '';
        $this->time = date('Y-m-d H:i:s');
    }
}