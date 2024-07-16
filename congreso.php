<?php 

    /*
    Plugin Name: [Sinapsis] ticket
    Plugin URI: https://sinapsis.com
    Description: Plugin para manejo de venta de entradas para congreso medicos
    Version: 1.0
    Author: Diego Baeza
    Author URI: https://sisnapsis.com
    License: GPL2
    */

    add_action( 'wp_enqueue_scripts', 'ajax_enqueue_scripts_congreso' );


    function ajax_enqueue_scripts_congreso() {


        wp_enqueue_script(
        'congreso-script',
        plugins_url( '/public/js/congreso.js', __FILE__ ), 
        array('jquery'),
        rand(0, 99),
        true
        );

        wp_enqueue_style( 
        'congreso-style',
        plugins_url( '/public/css/congreso.css', __FILE__ ),
        array(),
        rand(0, 99)
        );



        wp_localize_script(
            'congreso-script',
            'wp_ajax_congreso_ticket',
            array(
                'ajax_url_productos'    => plugins_url( '/public/productos.php' , __FILE__ ),
                'ajax_url_save_order'   => plugins_url( '/public/save_order.php' , __FILE__ ),
                'ajax_url_pay_ticket'   => plugins_url( '/public/pay_ticket.php' , __FILE__ ),
                'ajax_url_motores'      => plugins_url( '/public/motores.php' , __FILE__ ),
                'ajax_url_promo_code'   => plugins_url( '/public/promo_codes_validate.php' , __FILE__ )
            )
        );



    }


    function shortcode_congreso($atts){

        $smarty = new Smarty;

        $smarty->setTemplateDir(dirname(__FILE__) . '/public/partials/');
        $smarty->setCompileDir(dirname(__FILE__) .'/public/compile/');

        $usuarios = RfCoreCurl::curl('/api/ticket/usuarios' , 'GET' , NULL , NULL);

        $smarty->assign('usuarios', $usuarios);
        $smarty->assign('logo_paypal', plugins_url( '/public/assets/img/paypal_logo.svg' , __FILE__ ));
        $smarty->assign('logo_webpayl', plugins_url( '/public/assets/img/webpay_logo.svg' , __FILE__ ));

        return $smarty->fetch('congreso.tpl');
        
    }
    
    add_shortcode("shortcodecongreso" , "shortcode_congreso");


    function shortcode_pago_ok_ticket($atts){

        $order = $_GET["order"];

        $smarty = new Smarty;

        $smarty->setTemplateDir(dirname(__FILE__) . '/public/partials/');
        $smarty->setCompileDir(dirname(__FILE__) .'/public/compile/');

        $data_order = RfCoreCurl::curl('/api/ticket/get_order_by_id/'.$order , 'GET' , NULL , NULL);

        $data_user = RfCoreCurl::curl('/api/ticket/get_user_ticket_by_id/'.$data_order->response->id_usuario , 'GET' , NULL , NULL);

        $smarty->assign('order' , $order);
        $smarty->assign('motor' , $data_order->response->plataforma_pago);
        $smarty->assign('total' , $data_order->response->total);
        $smarty->assign('fecha' , $data_order->response->fecha);
        $smarty->assign('usuario' , $data_user->response->correo_electronico);
        $smarty->assign('productos' , $data_order->response->it);


        return $smarty->fetch('pagina_pago_ok.tpl');

    }

    add_shortcode("shortcodepagookticket" , "shortcode_pago_ok_ticket");

?>