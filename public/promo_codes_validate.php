<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');  

$errors = [];


if($_POST["promo_code"] != ''){

    $promo_code = $_POST["promo_code"];

    $data = RfCoreCurl::curl('/api/ticket/validar_codigo_descuento/'.$promo_code , 'GET' , NULL , NULL);

    if($data->status == true){

        if($data->response->unidades > 0){

            wp_send_json(array(
                'status' => true,
                'response' => $data
            ));

        }else if($data->response->unidades == 0){
            array_push($errors, ['id' => 'codigo_descuento' , 'text' => 'Este código ya fue utilizado.']);
            wp_send_json(array(
                'status' => false,
                'errors' => $errors
            ));
        }

    }else if($data->status == false){
        array_push($errors, ['id' => 'codigo_descuento' , 'text' => 'Código no encontrado.']);
        wp_send_json(array(
            'status' => false,
            'errors' => $errors
        ));
    }

}else{
    
    array_push($errors, ['id' => 'codigo_descuento' , 'text' => 'Debe ingresar un código.']);
    wp_send_json(array(
        'status' => false,
        'errors' => $errors
    ));

}



?>