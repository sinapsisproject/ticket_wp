<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

    $id_user = (int)$_POST["user_id"];

    $data = RfCoreCurl::curl('/api/ticket/productos/'.$id_user , 'GET' , NULL , NULL);

    $tipo_productos = $data->car;

    wp_send_json(array(
        'status' => true,
        'response' => $tipo_productos
    ));

?>