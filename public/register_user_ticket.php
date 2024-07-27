<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

$jsonData = $_POST["jsonData"];
$userData = $_POST["userData"];


$user_body = [
    "nombre"            => $userData["nombre_ticket"],
    "apellido"          => $userData["apellido_ticket"],
    "fecha_nacimiento"  => $userData["fecha_ticket"],
    "telefono"          => $userData["telefono_ticket"],
    "correo_electronico"=> $userData["correo_ticket"],
    "ocupacion"         => $userData["ocupacion_ticket"],
    "certificado"       => $userData["certificado_ticket"],
    "lugar_de_desempeño"=> $userData["trabajo_ticket"],
    "id_tipo_usuario"   => $jsonData["idUserType"],
    "id_pais"           => $userData["pais_ticket"]
];

$response_user_ticket = RfCoreCurl::curl('/api/ticket/register_user_ticket' , 'POST' , null, $user_body);

if($response_user_ticket->status == true){
    wp_send_json(array(
        'status'    => true,
        'response' => $response_user_ticket->response
    ));
}


?>