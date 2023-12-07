<?php

namespace Controllers;

use Model\Dato;
use Model\Led;

class APIController {
    public static function save_data(){
        date_default_timezone_set('America/Mexico_City');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST = json_decode(file_get_contents('php://input'), true);
            // debuguear($_POST);

            $data = [
                [
                    'led' => 1,
                    'voltage_V' => $_POST["led1"][0],
                    'power_mW' => $_POST["led1"][1],
                    'current_mA' => $_POST["led1"][2],
                ],
                [
                    'led' => 2,
                    'voltage_V' => $_POST["led2"][0],
                    'power_mW' => $_POST["led2"][1],
                    'current_mA' => $_POST["led2"][2],
                ],
                [
                    'led' => 3,
                    'voltage_V' => $_POST["led3"][0],
                    'power_mW' => $_POST["led3"][1],
                    'current_mA' => $_POST["led3"][2],
                ],
                [
                    'led' => 4,
                    'voltage_V' => $_POST["led4"][0],
                    'power_mW' => $_POST["led4"][1],
                    'current_mA' => $_POST["led4"][2],
                ]
            ];

            // debuguear($data);
            $apiKey = $_POST['api_key'];
            if($apiKey === $_ENV['API_KEY']){
                foreach($data as $dato){
                    $d = new Dato($dato);
                    $result = $d->guardar();
                }

                if($result){
                    echo json_encode([
                        'status' => 200,
                        'message' => 'Data saved successfully'
                    ]);
                }else{
                    echo json_encode([
                        'status' => 400,
                        'message' => 'Error saving data'
                    ]);
                }
            }else{
                echo json_encode([
                    'status' => 403,
                    'message' => 'Forbidden'
                ]);
            }
        }
    }

    public static function update_brightness(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST =json_decode(file_get_contents('php://input'), true);
            $apiKey = $_POST['api_key'];
            // debuguear($_POST);
            if($apiKey === $_ENV['API_KEY']){
                foreach($_POST['brightness'] as $key => $brightness){
                    $led_id = $key + 1;
                    $led = Led::find($led_id);
                    $led->brightness = $brightness;
                    $result = $led->guardar();
                }
                if($result){
                    echo json_encode([
                        'status' => 200,
                        'message' => 'Brightness updated successfully'
                    ]);
                }else{
                    echo json_encode([
                        'status' => 400,
                        'message' => 'Error updating brightness'
                    ]);
                }
            }else{
                echo json_encode([
                    'status' => 403,
                    'message' => 'Forbidden'
                ]);
            }
        }
    }

    public static function get_data(){
        $data = Dato::all();
        echo json_encode($data);
    }

    public static function update_leds(){
        $leds = Led::all();
        echo json_encode($leds);
    }
}