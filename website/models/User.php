<?php 

namespace Model;


class User extends ActiveRecord{
    protected static $tabla = 'users';
    protected static $columnasDB = ['username', 'name', 'last_name', 'password', 'image'];

    public $username;
    public $name;
    public $last_name;
    public $password;
    public $image;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->username = $args['username'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->image = $args['image'] ?? '';
    }

    public function validateLogin() {
        if(!$this->username) {
            self::$alertas['error'][] = 'The Username cannot be empty';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'The Password cannot be empty';
        }
        return self::$alertas;
    }
}