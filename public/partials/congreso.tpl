<div class="formulario_venta" style="display: block;">

    <div class="container">
        <div class="col-12 text-center">
            <h1 class="title-congreso">Endocrinología y Diabetología Hospitalaria: desde la Consulta a la UPC.</h1>
        </div>


        <div class="row justify-content-center mt-5">

            <div class="col-12 col-md-7">
                <p>Elige tu categoría</p>
                <select id="select-user-ticket" class="form-select" aria-label="Default select example">
                    <option selected>Selecciona una opción</option>
                    {foreach $usuarios as $usuario}
                        <option value="{$usuario->id}">{$usuario->nombre}</option>
                    {/foreach}
                </select>
            </div>

            <div class="col-12 col-md-7 mt-4">

                <div id="options-congreso-ticket"></div>

                <div class="col-12 text-center mt-5 mb-5" id="loading_progress_bar_congreso_ticket" style="display: none;">
                    <div style="width: 2rem; height: 2rem; margin-right: 6px; position: relative; top: 14px; color: #445AFF;" class="spinner-border mb-5" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

            </div>

            <div class="col-12 col-md-7 mt-4">
                <p class="subtotal_pesos">Subtotal:    <strong id="subtotal_pesos">$0</strong></p>
                <p class="subtotal_dolares">Subtotal:  <strong id="subtotal_dolares">$0 USD</strong></p>
                
                <div id="div_button_continue"></div>

            </div>

        </div>

    </div>

</div>


<div class="formulario_registro" style="display:none;">

    <div class="row">
        <div class="col-6 block-left" style="background: white;">
           <h3>Datos de compra</h3>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Nombre</label>
                <input id="nombre_ticket" type="text" class="form-control">
                <div id="nombre_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Apellido</label>
                <input id="apellido_ticket" type="text" class="form-control">
                <div id="apellido_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Correo electrónico</label>
                <input id="correo_ticket" type="mail" class="form-control">
                <div id="correo_ticket_register_error"></div>
                <div id="correo_ticket_register_error_2"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Fecha de nacimiento</label>
                <input id="fecha_ticket" type="date" class="form-control">
                <div id="fecha_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label" style="color: #695C5C;">País</label>
                <select style="border-color: #cccdcd; height: 43px;" class="form-select" id="pais_ticket">
                    <option selected value="">Seleccione un país</option>
                    <option value="1">Chile</option>
                    <option value="2">Argentina</option>
                    <option value="3">Bolivia</option>
                    <option value="4">Brasil</option>
                    <option value="5">Colombia</option>
                    <option value="6">Costa Rica</option>
                    <option value="7">Ecuador</option>
                    <option value="8">El Salvador</option>
                    <option value="9">Guatemala</option>
                    <option value="10">Honduras</option>
                    <option value="11">México</option>
                    <option value="12">Nicaragua</option>
                    <option value="13">Panamá</option>
                    <option value="14">Paraguay</option>
                    <option value="15">Perú</option>
                    <option value="16">República Dominicana</option>
                    <option value="17">Uruguay </option>
                    <option value="18">Venezuela</option>
                </select>
                <div id="pais_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Teléfono</label>
                <input id="telefono_ticket" type="text" class="form-control">
                <div id="telefono_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Ocupación</label>
                <input id="ocupacion_ticket" type="text" class="form-control">
                <div id="ocupacion_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Lugar de desempeño</label>
                <input id="trabajo_ticket" type="text" class="form-control">
                <div id="trabajo_ticket_register_error"></div>
            </div>

            <div class="col-12 col-md-9 mb-3">
                <label class="form-label">Contraseña</label>
                <input id="contrasena_ticket" type="password" class="form-control">
                <div id="contrasena_ticket_register_error"></div>
            </div>

            <button id="button_pay_ticket" type="button" style="display: inline-flex;">
                <div id="loading_register_ticket" style="width: 1rem; height: 1rem; margin-right: 10px; display: none; margin-top: 4px;" class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                 Ir a pagar
            </button>

        </div>
        <div class="col-6 block-right" style="background: #445AFF;">
        
            <div class="row">
                <div class="col-12 col-md-5">
                    <img src="http://local.sinapsis.cl/wp-content/uploads/2024/02/Estrategia-HEARTS.png" alt="">
                </div>
                <div class="col-12 col-md-7">
                    <p style="font-size: 20px"><strong>Endocrinología y Diabetología Hospitalaria: desde la Consulta a la UPC.</strong></p>
                </div>

                <div class="col-12 mt-4">
                    <h4>Detalles</h4>

                    <div class="row" id="list_products">
                        
                    </div>

                    <div id="totales_products">
                        
                    </div>

                </div>

            </div>


        </div>
    </div>



    <div class="modal fade" id="modalpayticket" aria-hidden="true" aria-labelledby="modalpayticket" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <h3 style="color: #445AFF;">Método de pago</h3>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p>Desde Chile</p>
                                    <input value="webpay" type="radio" class="btn-check" name="options" id="option1">
                                    <label class="button_type_pay btn btn-secondary" for="option1"><img src="/wp-content/plugins/congreso_wp/public/assets/img/webpay_logo.svg" alt=""></label>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <div id="precio_pesos_pay"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p>Desde el extranjero</p>
                                    <input value="paypal" type="radio" class="btn-check" name="options" id="option2">
                                    <label class="button_type_pay btn btn-secondary" for="option2"><img src="/wp-content/plugins/congreso_wp/public/assets/img/paypal_logo.svg" alt=""></label> 
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <div id="precio_dolares_pay"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div id="divbuttonwebpay"></div>
                    <button id="button_insert_pay_motor" class="btn btn-primary" data-bs-target="#modalpayticket">

                    <div id="loading_pay_ticket" style="width: 1rem; height: 1rem; margin-right: 10px; display: none; margin-top: 4px;" class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                        Pagar
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>
