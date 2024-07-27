<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

$user = $_POST["user"];
$pass = $_POST["pass"];  

if($user != '' && $pass != ''){

    $data = ["email" => $user , "pass" => $pass];    

    $response = RfCoreCurl::curl('/api/ticket/login_user_ticket/' , 'POST' , null, $data);

    if($response->status == true){

        $data_user = $response->response_user[0];

        if(count($response->response_user_ticket) == 1){

            $data_user_ticket = $response->response_user_ticket[0];

            $user_data = array(
                'id_user_ticket'    => $data_user_ticket->id,
                'id_user'           => $data_user->id,
                'nombre_ticket'     => $data_user_ticket->nombre,
                'apellido_ticket'   => $data_user_ticket->apellido,
                'correo_ticket'     => $data_user_ticket->correo_electronico,
                'fecha_ticket'      => $data_user_ticket->fecha_nacimiento,
                'pais_ticket'       => $data_user_ticket->id_pais,
                'telefono_ticket'   => $data_user_ticket->telefono,
                'ocupacion_ticket'  => $data_user_ticket->ocupacion,
                'certificado_ticket'=> $data_user_ticket->certificado,
                'trabajo_ticket'    => $data_user_ticket->lugar_de_desempeño,
                'contrasena_ticket' => $pass
            );

        }else{
            $user_data = [];
        }

        wp_send_json(array(
            'status'    => true,
            'response'  => $user_data,
            'id_user'   => $data_user->id
        ));


    }

    

   

}else{

    wp_send_json(array(
        'status'    => false,
        'message'  => "Contraseña incorrecta"
    ));

}





?>