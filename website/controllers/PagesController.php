<?php

namespace Controllers;

use Model\Dato;
use Model\Led;
use Model\User;
use MVC\Router;

class PagesController {
    public static function index(Router $router) {
        if(!is_auth()) header('Location: /login');
        
        $router->render('index', [
            'title' => 'Home Page',
            'active_page' => 'home'
        ]); 
    }

    public static function circuit(Router $router) {
        if(!is_auth()) header('Location: /login');

        $leds = Led::all();
        
        $router->render('circuit', [
            'title' => 'Circuit',
            'active_page' => 'circuit',
            'leds' => $leds
        ]); 
    }

    public static function graphs(Router $router) {
        if(!is_auth()) header('Location: /login');

        $data = Dato::all();
        $days = [];
        foreach($data as $dato) {
            $days[] = explode('-', explode(' ', $dato->time)[0])[2];
        }
        $days = array_unique($days);
        
        $router->render('graphs', [
            'title' => 'Graphs',
            'active_page' => 'graphs',
            'days' => $days
        ]); 
    }

    public static function login(Router $router) {
        if(is_auth()) header('Location: /');
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            // debuguear($_POST);
            $alerts = $user->validateLogin();
            
            if(empty($alerts)) {
                // Verificar quel el usuario exista
                $user = User::where('username', $user->username);
                if(!$user ) {
                    User::setAlerta('error', 'User does not exist');
                } else {
                    // El Usuario existe
                    if( password_verify($_POST['password'], $user->password) ) {
                        
                        // Iniciar la sesión
                        session_start();   
                        $_SESSION['id'] = $user->id;
                        $_SESSION['username'] = $user->username;
                        $_SESSION['name'] = $user->name;
                        $_SESSION['last_name'] = $user->last_name;
                        $_SESSION['image'] = $user->image;
                        
                        // Redireccion
                        header('Location: /');
                        
                    } else {
                        User::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }

            $alerts = User::getAlertas();
        }
        $router->render('login', [
            'title' => 'Login',
            'alerts' => $alerts
        ]); 
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /login');
    }
}