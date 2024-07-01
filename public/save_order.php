<?php 

require(dirname(__FILE__) .'/../../../../wp-load.php');

$errors = array();

if(sanitize_user($_POST["nombre_ticket"]) == ''){
    array_push($errors, ['id' => 'nombre_ticket' , 'text' => 'El campo Nombre es requerido.']);
}else{
    $nombre_ticket   = sanitize_user($_POST["nombre_ticket"]);
}

if(sanitize_user($_POST["apellido_ticket"]) == ''){
    array_push($errors, ['id' => 'apellido_ticket' , 'text' => 'El campo Apellido es requerido.']);
}else{
    $apellido_ticket   = sanitize_user($_POST["apellido_ticket"]);
}

if($_POST["correo_ticket"] == ''){
    array_push($errors, ['id' => 'correo_ticket' , 'text' => 'El campo Correo electrónico es requerido.']);
}else if(strlen($_POST["correo_ticket"]) > 0 && sanitize_email($_POST["correo_ticket"]) == ''){
    array_push($errors, ['id' => 'correo_ticket' , 'text' => 'El Correo electrónico no es válido']);
}else if(strlen($_POST["correo_ticket"]) > 0 && email_exists(sanitize_email($_POST["correo_ticket"]))){
    array_push($errors , ['id' => 'correo_ticket' , 'text' => 'El Correo electrónico ya fue registrado']);
}else{
    $correo_ticket  = sanitize_email($_POST["correo_ticket"]);
}

if(esc_attr($_POST["fecha_ticket"]) == ''){
    array_push($errors, ['id' => 'fecha_ticket' , 'text' => 'El campo fecha de nacimiento es requerido']);
}else{
    $fecha_ticket  = esc_attr($_POST["fecha_ticket"]);
}

if(sanitize_user($_POST["pais_ticket"]) == ''){
    array_push($errors, ['id' => 'pais_ticket' , 'text' => 'El campo país es requerido.']);
}else{
    $pais_ticket   = sanitize_user($_POST["pais_ticket"]);
}

if(esc_attr($_POST["telefono_ticket"]) == ''){
    array_push($errors, ['id' => 'telefono_ticket' , 'text' => 'El campo teléfono es requerido']);
}else{
    $telefono_ticket  = esc_attr($_POST["telefono_ticket"]);
}

if(sanitize_user($_POST["ocupacion_ticket"]) == ''){
    array_push($errors, ['id' => 'ocupacion_ticket' , 'text' => 'El campo Ocupación es requerido.']);
}else{
    $ocupacion_ticket   = sanitize_user($_POST["ocupacion_ticket"]);
}

if(sanitize_user($_POST["trabajo_ticket"]) == ''){
    array_push($errors, ['id' => 'trabajo_ticket' , 'text' => 'El campo Lugar de desempeño es requerido.']);
}else{
    $trabajo_ticket   = sanitize_user($_POST["trabajo_ticket"]);
}

if(esc_attr($_POST["contrasena_ticket"]) == ''){
    array_push($errors, ['id' => 'contrasena_ticket' , 'text' => 'El campo Contraseña es requerido.']);
}else if(strlen(esc_attr($_POST["contrasena_ticket"])) > 0 && strlen(esc_attr($_POST["contrasena_ticket"])) <= 5){
    array_push($errors, ['id' => 'contrasena_ticket' , 'text' => 'La Contraseña debe tener más de 5 caracteres']);
}else{
    $contrasena_ticket   = esc_attr($_POST["contrasena_ticket"]);
}


if(count($errors) > 0){
    wp_send_json( array(
        'status' => false,
        'errors' => $errors
    )); 
}else{

    $user_data = array(
        'nombre_ticket'     => $nombre_ticket,
        'apellido_ticket'   => $apellido_ticket,
        'correo_ticket'     => $correo_ticket,
        'fecha_ticket'      => $fecha_ticket,
        'pais_ticket'       => $pais_ticket,
        'telefono_ticket'   => $telefono_ticket,
        'ocupacion_ticket'  => $ocupacion_ticket,
        'trabajo_ticket'    => $trabajo_ticket,
        'contrasena_ticket' => $contrasena_ticket
    );

    wp_send_json(array(
        'status'    => true,
        'user_data' => $user_data
    ));

}







?>