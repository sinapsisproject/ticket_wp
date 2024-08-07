<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

$jsonData = $_POST["json_data"];
$platformPay = $_POST["platform_pay"];
$userData = $_POST["user_data"];
$date = $_POST["date"];
$promo_code = $_POST["promo_code"];
$nombre = $userData["nombre_ticket"]." ".$userData["apellido_ticket"];
$login = $_POST["login"];

if($login == 0){

    $response_user_sinapsis = RfCoreUtils::register_user($nombre , $userData["correo_ticket"] , $userData["correo_ticket"] , $userData["fecha_ticket"] , $userData["pais_ticket"] , $userData["telefono_ticket"] , $userData["contrasena_ticket"] , 'activo' , 1);

    if($response_user_sinapsis->status == true){

        $user_data = array(
            'user_login' => $userData["correo_ticket"],
            'user_pass'  =>  $userData["contrasena_ticket"],
            'user_email' => $userData["correo_ticket"],
            'role'       => 'subscriber',
            'show_admin_bar_front' => 'false'
        );
        $user_id = wp_insert_user($user_data);
    
        $user_body = [
            "nombre"    => $userData["nombre_ticket"],
            "apellido"  => $userData["apellido_ticket"],
            "fecha_nacimiento" => $userData["fecha_ticket"],
            "telefono" => $userData["telefono_ticket"],
            "correo_electronico" => $userData["correo_ticket"],
            "ocupacion" => $userData["ocupacion_ticket"],
            "certificado" => $userData["certificado_ticket"],
            "lugar_de_desempeño" => $userData["trabajo_ticket"],
            "id_tipo_usuario" => $jsonData["idUserType"],
            "id_pais" => $userData["pais_ticket"]
        ];
    
        $response_user_ticket = RfCoreCurl::curl('/api/ticket/register_user_ticket' , 'POST' , null, $user_body);
    
    
        if($response_user_ticket->status == true){
    
            $order_body = [
                    "idUserType" => $jsonData["idUserType"],
                    "idPacks" => $jsonData["idPacks"],
                    "promo_code" => $promo_code,
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


}else{


    $order_body = [
        "idUserType" => $jsonData["idUserType"],
        "idPacks" => $jsonData["idPacks"],
        "promo_code" => $promo_code,
        "dataUser" => [
                "fecha" => $date,
                "plataforma_pago" => $platformPay,
                "id_usuario" => $userData["id_user_ticket"],
                "id_usuario_sinapsis" => $userData["id_user"]
            ]
        ];

    $response_order = RfCoreCurl::curl('/api/ticket/create_order_ticket' , 'POST' , null, $order_body);

    if($response_order->response == true){
        wp_send_json(array(
            'status'    => true,
            'msg'       => "datos ingresados",
            'response_order' => $response_order
        ));
    }




}





?>