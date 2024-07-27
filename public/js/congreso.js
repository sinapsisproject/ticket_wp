let jsonData = {};
let userData = {};

let precio_pesos;
let precio_dolar;

let login = 0;

jQuery(document).ready( function(){

  let valor = 0;
  let subtotal_pesos = 0;
  let subtotal_dolares = 0;
  

  jQuery('#options-congreso-ticket').on('change' , '.btn-check' ,function() {

    //  let online = jQuery(this).attr('maxOnline');
    //  let presencial = jQuery(this).attr('maxPresencial');

    // console.log(online);
    // console.log(presencial);
    
    if(jQuery(this).is(':checked')) {
        valor = jQuery(this).val();
        subtotal_pesos = parseInt(subtotal_pesos) + parseInt(valor);
    } else {
        valor = jQuery(this).val();
        subtotal_pesos = parseInt(subtotal_pesos) - parseInt(valor);
    }

    jQuery('#subtotal_pesos').html(formattedNumberChileanMoney(subtotal_pesos));

    subtotal_dolares = convertirCLPtoUSD(subtotal_pesos);

    jQuery('#subtotal_dolares').html('$'+subtotal_dolares+' USD');


    jQuery('#div_button_continue').html('<button id="button_continue" type="button">Continuar</button>');

    if(subtotal_pesos == 0){
      console.log(subtotal_pesos);
      jQuery("#div_button_continue").html('');
    }

  })


  jQuery('#select-user-ticket').on('change', function() {
    
      valor = 0;
      subtotal_pesos = 0;
      jQuery('#subtotal_pesos').html('$0');
      jQuery('#subtotal_dolares').html('$0 USD');
      jQuery('#div_button_continue').html('');


      let user_id = jQuery("#select-user-ticket").val();
      
      let data = {
        "user_id" : user_id
      }

      jQuery.ajax({
            type : "post",
            data : data,
            url : wp_ajax_congreso_ticket.ajax_url_productos,
            error: function(response){
                console.log(response);
            },
            success: function(res) {

              if(res.status){

                let html = '<p>Opciones</p>';

                res.response.forEach(tp => {

                  // console.log(tp);
                  // let max_online = tp.cant_curso_online;
                  // let max_presencial = tp.cant_curso_presencial;
                  // let id_button = tp.id;

                  if(tp.tpt != null){
                    html += '<button class="collapse-congreso-item btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#'+tp.id+'_collapse" aria-expanded="false" aria-controls="collapseExample">'+
                              tp.tpt.nombre+
                            '</button>';
                    
                    html += '<div class="collapse collapse-congreso" id="'+tp.id+'_collapse">';
                              
                    tp.tpt.pa.forEach(pack => {

                        if(pack.ud.length == 1){
                            
                            pack.ud.forEach(unidad => {

                              var valor_producto = 'no definido';

                              unidad.pt.pre.forEach(precio => {
                                
                                if(precio.tpre.nombre_precio == 'Preventa 1' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor;            
                                }else if(precio.tpre.nombre_precio == 'Preventa 2' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor;  
                                }else if(precio.tpre.nombre_precio == 'Preventa 3' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor;  
                                }

                              });

                              html += '<input nameProduct="'+unidad.pt.nombre+'" packId="'+pack.id+'" value="'+valor_producto+'" type="checkbox" class="btn-check" id="btn-check-'+pack.id+'-outlined" autocomplete="off">'+
                                      '<label class="input-check-congreso btn btn-outline-secondary mb-2" for="btn-check-'+pack.id+'-outlined">'+unidad.pt.nombre+ ' - <strong>'+formattedNumberChileanMoney(valor_producto)+'</strong></label>';
    
                            });

                        }

                        if(pack.ud.length > 1){
                            let name = '';
                            let c = 1;

                            var valor_producto = 0;
                            pack.ud.forEach(unidad => {

                              unidad.pt.pre.forEach(precio => {
                                
                                if(precio.tpre.nombre_precio == 'Preventa 1' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor + valor_producto;            
                                }else if(precio.tpre.nombre_precio == 'Preventa 2' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor + valor_producto;  
                                }else if(precio.tpre.nombre_precio == 'Preventa 3' && precio.tpre.estado == 'activo'){
                                  valor_producto = precio.valor;
                                }

                              });


                              if(pack.ud.length == c){
                                name += unidad.pt.nombre
                              }else{
                                name += unidad.pt.nombre+" + ";
                              }
                              c++;
                          });

                          html += '<input nameProduct="'+name+'" packId="'+pack.id+'" value="'+valor_producto+'" type="checkbox" class="btn-check" id="btn-check-'+pack.id+'-outlined" autocomplete="off">'+
                                  '<label class=" input-check-congreso btn btn-outline-secondary mb-2" for="btn-check-'+pack.id+'-outlined">'+name+ ' - <strong>'+formattedNumberChileanMoney(valor_producto)+'</strong></label>';
                        }       

                    });

                    html += '</div>';

                  }

                  
                });

                jQuery("#options-congreso-ticket").html(html);

              } 
               
            },
            beforeSend: function (qXHR, settings) {
                jQuery("#options-congreso-ticket").html('');
                jQuery('#loading_progress_bar_congreso_ticket').fadeIn();
            },
            complete: function () {
                jQuery('#loading_progress_bar_congreso_ticket').fadeOut();
            },
        })



  })


  jQuery("#div_button_continue").on('click' , '#button_continue' , function(){

      let id_tipo_usuario = parseInt(jQuery('#select-user-ticket').val());

      let packs = [];
      let labelPacks = [];
      precio_pesos = 0;
      precio_dolar = 0;
      jQuery('.btn-check:checked').each(function() {
        let valor = parseInt(jQuery(this).attr('packId'));
        packs.push(valor);

        labelPacks.push(
          {
            "nombre" : jQuery(this).attr('nameproduct'),
            "valor" : jQuery(this).val()
          }
        );

        precio_pesos = precio_pesos + parseInt(jQuery(this).val());


      });


      let html_products = '';
      let html_totales = '';
      labelPacks.forEach(producto => {

        html_products += '<div class="col-8">'+
                            '<p>'+producto.nombre+'</p>'+
                        '</div>'+
                        '<div class="col-4 text-end">'+
                            '<p>'+formattedNumberChileanMoney(producto.valor)+'.-</p>'+
                        '</div>';

      });


      html_totales += '<div class="row mt-5">'+
                            '<div class="col-6">'+
                                '<p>Subtotal:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p>'+formattedNumberChileanMoney(precio_pesos)+'.-</p>'+
                            '</div>'+
                        '</div>'+

                        '<hr style="height: 2px; background-color: white;  border: none;">'+

                        '<div class="row" id="totales_products">'+
                            '<div class="col-6">'+
                                '<p style="font-size: 20px;">Total:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p style="font-size: 20px;">'+formattedNumberChileanMoney(precio_pesos)+'.-</p>'+
                            '</div>'+

                            '<div class="col-6">'+
                                '<p style="font-size: 20px;">Total dólares:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p style="font-size: 20px;">$'+precio_pesos / 1000+' USD.-</p>'+
                            '</div>'+
                        '</div>'


      jQuery("#list_products").html(html_products);
      jQuery("#totales_products").html(html_totales);
      jQuery("#precio_pesos_pay").html('<p style="font-size: 20px;">'+formattedNumberChileanMoney(precio_pesos)+'.-</p>');
      jQuery("#precio_dolares_pay").html('<p style="font-size: 20px;">$'+precio_pesos / 1000+' USD.-</p>')


      jsonData = {
        "idUserType" : id_tipo_usuario,
        "idPacks"    : packs
      }

      jQuery(".formulario_registro").css("display" , "block");
      jQuery(".formulario_venta").css("display" , "none");


  })



  jQuery("#button_pay_ticket").on("click" , function(){

    //let fileInput = jQuery('#certificado_ticket')[0].files[0];
    //console.log(formData);

      let nombre_ticket     = jQuery("#nombre_ticket").val();
      let apellido_ticket   = jQuery("#apellido_ticket").val();
      let correo_ticket     = jQuery("#correo_ticket").val();
      let fecha_ticket      = jQuery("#fecha_ticket").val();
      let pais_ticket       = jQuery("#pais_ticket").val();
      let telefono_ticket   = jQuery("#telefono_ticket").val();
      let ocupacion_ticket  = jQuery("#ocupacion_ticket").val();
      let certificado_ticket= jQuery('#certificado_ticket')[0].files[0];
      let trabajo_ticket    = jQuery("#trabajo_ticket").val();
      let contrasena_ticket = jQuery("#contrasena_ticket").val();


      const formData = new FormData();
      formData.append('nombre_ticket', nombre_ticket);
      formData.append('apellido_ticket', apellido_ticket);
      formData.append('correo_ticket', correo_ticket);
      formData.append('fecha_ticket', fecha_ticket);
      formData.append('pais_ticket', pais_ticket);
      formData.append('telefono_ticket', telefono_ticket);
      formData.append('ocupacion_ticket', ocupacion_ticket);
      formData.append('certificado_ticket', certificado_ticket);
      formData.append('trabajo_ticket', trabajo_ticket);
      formData.append('contrasena_ticket', contrasena_ticket);
      formData.append('jsonData', jsonData);
      


      jQuery.ajax({
        type : "post",
        url : wp_ajax_congreso_ticket.ajax_url_save_order,
        data : formData,
        contentType: false,
        processData: false,
        error: function(response){
            console.log(response);
        },
        success: function(response) {

            jQuery('[id*="_register_error"]').html("");

            if(response.status == false){
              response.errors.forEach(element => {
                 jQuery("#"+element.id+"_register_error").html("<p style='color : #ff7c7c; font-size: 12px;'>"+element.text+"</p>");
              });

              if(response.errors.length == 1){
                Object.values(response.errors).forEach(error => {
                    if(error.id == 'correo_registrado_ticket'){
                      jQuery('#email_login_ticket').val(correo_ticket);
                      userData = response.user_data;
                      jQuery('#modal_login').modal('show');//usuario ya registrado
                    }
                });
              }
              
            }else{
              if(response.status == true){//usuario nuevo

                jQuery('#modalpayticket').modal('show');
                
                userData = response.user_data;
                console.log(userData);

              }
            }
          

        },
        beforeSend: function (qXHR, settings) {
            jQuery('#loading_register_ticket').fadeIn();
        },
        complete: function () {
            jQuery('#loading_register_ticket').fadeOut();
        },
    })



  });




  function formattedNumberChileanMoney(number){

    if(number == "no definido"){
      return "no definido";
    }else{
      return new Intl.NumberFormat('es-CL', {
        style: 'currency',
        currency: 'CLP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      }).format(number);
    }

  }


  function convertirCLPtoUSD(pesosChilenos) {
    const dolares = pesosChilenos / 1000;
    return dolares;
  }



  jQuery("#button_insert_pay_motor").on("click" , function(){

    const plataforma = jQuery('input[name="options"]:checked').val();
    const promo_code = jQuery("#codigo_descuento_ticket").val();

    console.log(promo_code);

    const data = {
      user_data : userData,
      platform_pay : plataforma,
      json_data : jsonData,
      date : new Date(),
      promo_code : promo_code,
      login : login
    }

    jQuery.ajax({
        type : "post",
        url : wp_ajax_congreso_ticket.ajax_url_pay_ticket,
        data : data,
        error: function(response){
            console.log(response);
        },
        success: function(response) {

          console.log(response);

          if(response.status == false){

            if(response.response.msg){
              jQuery("#correo_ticket_register_error_2").html('<p style="color : #ff7c7c; font-size: 12px;">'+response.response.msg+'</p>');
            }

          }

          if(response.status == true){

            let data_pago = {
              "id_orden" : response.response_order.response.id
            }

            jQuery.ajax({
              type : "post",
              url : wp_ajax_congreso_ticket.ajax_url_motores,
              data : data_pago,
              error: function(response){
                  console.log(response);
              },
              success: function(response) {
  
                console.log(response);

                  if(response.status == true){

                    if(response.motor == "webpay"){

                      jQuery('#divbuttonwebpay').html(
                        '<form id="formwebpay" action="'+response.url+'" method="POST">'+
                        '<input type="hidden" name="token_ws" value="'+response.token+'"/>'+
                        '</form>'
                      );
  
                      jQuery('#formwebpay').submit();

                    }

                    if(response.motor == "paypal"){

                      window.location.replace(response.url_redirect);

                    }

                  }
              }
    
          })

          }

        },
        beforeSend: function (qXHR, settings) {
            jQuery('#loading_pay_ticket').fadeIn();
        },
        complete: function () {
            //jQuery('#loading_register_ticket').fadeOut();
        },
    })

  });


  jQuery("#promo_code_button").on("click" , function(){

    let html_desc_totales = "";

    let codigo = jQuery("#codigo_descuento_ticket").val();

    let data = {
      "promo_code" : codigo
    }

    jQuery.ajax({
      type : "post",
      url : wp_ajax_congreso_ticket.ajax_url_promo_code,
      data : data,
      error: function(response){
          console.log(response);
      },
      success: function(response) {

        jQuery('[id*="_promo_error"]').html("");

        if(response.status == false){

          let html_totales_error = '';

          response.errors.forEach(element => {
            jQuery("#"+element.id+"_promo_error").html("<p style='color : #ff7c7c; font-size: 13px;'>"+element.text+"</p>");
          });

          html_totales_error += '<div class="row mt-5">'+
            '<div class="col-6">'+
                '<p>Subtotal:</p>'+
            '</div>'+
            '<div class="col-6 text-end">'+
                '<p>'+formattedNumberChileanMoney(precio_pesos)+'.-</p>'+
            '</div>'+
            '</div>'+

            '<hr style="height: 2px; background-color: white;  border: none;">'+

            '<div class="row" id="totales_products">'+
                '<div class="col-6">'+
                    '<p style="font-size: 20px;">Total:</p>'+
                '</div>'+
                '<div class="col-6 text-end">'+
                    '<p style="font-size: 20px;">'+formattedNumberChileanMoney(precio_pesos)+'.-</p>'+
                '</div>'+

                '<div class="col-6">'+
                    '<p style="font-size: 20px;">Total dólares:</p>'+
                '</div>'+
                '<div class="col-6 text-end">'+
                    '<p style="font-size: 20px;">$'+precio_pesos / 1000+' USD.-</p>'+
                '</div>'+
            '</div>';

            jQuery("#totales_products").html(html_totales_error);
            jQuery("#precio_pesos_pay").html('<p style="font-size: 20px;">'+formattedNumberChileanMoney(precio_pesos)+'.-</p>');
            jQuery("#precio_dolares_pay").html('<p style="font-size: 20px;">$'+precio_pesos / 1000+' USD.-</p>');
            

        }else if(response.status == true){
         
          let descuento = response.response.response.descuento;
          let monto_descuento = (precio_pesos * descuento) / 100;
          let new_price = precio_pesos - monto_descuento;

          html_desc_totales += '<div class="row mt-5">'+
                            '<div class="col-6">'+
                                '<p>Subtotal:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p>'+formattedNumberChileanMoney(precio_pesos)+'.-</p>'+
                            '</div>'+
                        '</div>'+

                        '<hr style="height: 2px; background-color: white;  border: none;">'+

                        '<div class="row" id="totales_products">'+

                            '<div class="col-6 mt-4">'+
                                '<p style="font-size: 16px;">Descuento:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end mt-4">'+
                                '<p style="font-size: 16px;">'+descuento+' %OFF.-</p>'+
                            '</div>'+


                            '<div class="col-6">'+
                                '<p style="font-size: 20px;">Total:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p style="font-size: 20px;">'+formattedNumberChileanMoney(new_price)+'.-</p>'+
                            '</div>'+

                            '<div class="col-6">'+
                                '<p style="font-size: 20px;">Total dólares:</p>'+
                            '</div>'+
                            '<div class="col-6 text-end">'+
                                '<p style="font-size: 20px;">$'+new_price / 1000+' USD.-</p>'+
                            '</div>'+
                        '</div>'



          jQuery("#totales_products").html(html_desc_totales);
          jQuery("#precio_pesos_pay").html('<p style="font-size: 20px;">'+formattedNumberChileanMoney(new_price)+'.-</p>');
          jQuery("#precio_dolares_pay").html('<p style="font-size: 20px;">$'+new_price / 1000+' USD.-</p>');

        }

      },
      beforeSend: function (qXHR, settings) {
        jQuery('#promo_code_button_loading').fadeIn();
      },
      complete: function () {
        jQuery('#promo_code_button_loading').fadeOut();
      },

   })

  })


  jQuery("#login_ticket").on("click" , function(){

    user = jQuery("#email_login_ticket").val();
    pass = jQuery("#password_login_ticket").val();

    data = {
      "user" : user,
      "pass" : pass
    }

    jQuery.ajax({
      type : "post",
      url : wp_ajax_congreso_ticket.ajax_login_ticket,
      data : data,
      error: function(response){
          console.log(response);
      },
      success: function(response) {

        if(response.status == true){
          
          console.log("RESPONSE DEL LOGIN");
          console.log(response);

          let id_user_sinapsis = response.id_user;
         
          if(response.response.length != 0){

            jQuery('#modal_login').modal('hide');
            jQuery('#modalpayticket').modal('show');
            userData = response.response;
            login = 1;

          }else{

            userData.correo_ticket = jQuery("#correo_ticket").val();
            
            let data = {
              "userData" : userData,
              "jsonData" : jsonData
            }

            jQuery.ajax({
              type : "post",
              url : wp_ajax_congreso_ticket.ajax_register_user_ticket,
              data : data,
              error: function(response){
                  console.log(response);
              },
              success: function(response) {
                
                if(response.status == true){
                  jQuery('#modal_login').modal('hide');
                  jQuery('#modalpayticket').modal('show');
                  userData = response.response;

                  userData.id_user_ticket = userData.id;
                  userData.id_user = id_user_sinapsis;

                  console.log("RESPONSE DEL USERDATA");
                  console.log(userData);

                  login = 1;                
                }
      
              }
          })



          }

        }else{
          jQuery("#error_password_ticket").html('<p style="color: red">Contraseña incorrectar</p>');
        }

      },
      beforeSend: function (qXHR, settings) {
        jQuery('#loading_pay_ticket_login').fadeIn();
      },
      complete: function () {
        jQuery('#loading_pay_ticket_login').fadeOut();
      },

  })

  })


})
