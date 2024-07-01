<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');


$jsonData = $_POST["json_data"];
$platformPay = $_POST["platform_pay"];
$userData = $_POST["user_data"];
$date = $_POST["date"];


$response_user_sinapsis = RfCoreUtils::register_user($userData["nombre_ticket"] , $userData["correo_ticket"] , $userData["correo_ticket"] , $userData["fecha_ticket"] , $userData["pais_ticket"] , $userData["telefono_ticket"] , $userData["contrasena_ticket"] , 'activo' , 1);

if($response_user_sinapsis->status == true){

    $user_body = [
        "nombre"    => $userData["nombre_ticket"],
        "apellido"  => $userData["apellido_ticket"],
        "fecha_nacimiento" => $userData["fecha_ticket"],
        "telefono" => $userData["telefono_ticket"],
        "correo_electronico" => $userData["correo_ticket"],
        "ocupacion" => $userData["ocupacion_ticket"],
        "lugar_de_desempeño" => $userData["trabajo_ticket"],
        "id_tipo_usuario" => $jsonData["idUserType"],
        "id_pais" => $userData["pais_ticket"]
    ];

    $response_user_ticket = RfCoreCurl::curl('/api/ticket/register_user_ticket' , 'POST' , null, $user_body);


    if($response_user_ticket->status == true){

        $order_body = [
                "idUserType" => $jsonData["idUserType"],
                "idPacks" => $jsonData["idPacks"],
                "dataUser" => [
                        "fecha" => $date,
                        "plataforma_pago" => $platformPay,
                        "id_usuario" => $response_user_ticket->response->id,
                        "id_usuario_sinapsis" => $response_user_sinapsis->data->id
                    ]
                ];

        $response_order = RfCoreCurl::curl('/api/ticket/create_order_ticket' , 'POST' , null, $order_body);

        if($response_order->response == true){
            wp_send_json(array(
                'status'    => true,
                'msg'       => "datos ingresados",
                'response_user_sinapsis'  => $response_user_sinapsis,
                'response_user_ticket' => $response_user_ticket,
                'response_order' => $response_order
            ));
        }

    }

}else{
    wp_send_json(array(
        'status'    => false,
        'response'  => $response
    ));
}



?>