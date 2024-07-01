<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

    $id_orden = $_POST["id_orden"];

    
    $data_orden =  RfCoreCurl::curl('/api/ticket/get_order_by_id/'.$id_orden , 'GET' , null, null);


    if($data_orden->status == true){

        if($data_orden->response->plataforma_pago == "webpay"){

            $response_webpay = RfCoreCurl::curl('/api/webpay/order/'.$data_orden->response->id , 'POST' , null, null);

            wp_send_json($response_webpay);

        }else if($data_orden->response->plataforma_pago == "paypal"){

            $data_paypal = [
                "id_usuario" => $data_orden->response->id_usuario,
                "id_orden"   => $data_orden->response->id
            ];

            $response_paypal = RfCoreCurl::curl('/api/paypal/order' , 'POST' , null, $data_paypal);

            wp_send_json($response_paypal);

        }

    }


?>