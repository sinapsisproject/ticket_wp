<div class="row">
    <div class="col-12 text-center title-pay-ok">
        <i class="fa-solid fa-circle-check"></i>
        <h1>¡Pago Exitoso!</h1>
    </div>

    <div class="row mt-3 mb-4 shadow box-detail-pay">
        <div class="col-12">
            <div class="row">
                <div class="col-12 mb-4 text-center">
                    <p style="font-size: 30px; font-weight: bold; margin-bottom: 2px;">Nº de orden: {$order}</p>
                    <p><i style="margin-right: 10px;" class="fa-solid fa-calendar-days"></i> {$fecha|date_format:"%d-%m-%Y"}</p>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-12 col-md-7 text-center">
                        <p style="font-size: 20px;">Detalle de tu compra:</p>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="row">
                            {foreach from=$productos item=producto}
                            <div class="col-6 text-start">
                                <p>{$producto->nombre_producto}</p>
                            </div>
                            <div class="col-6 text-end">
                                {if $motor == 'paypal'}
                                <p>$ {$producto->precio / 1000} USD</p>
                                {/if}
                                {if $motor == 'webpay'}
                                <p>$ {$producto->precio|number_format:0:',':'.'}</p>
                                {/if}
                            </div>
                            {/foreach}
                            <hr>
                            <div class="col-6 text-start">
                                <p><strong>Total:</strong></p>
                            </div>
                            <div class="col-6 text-end">
                                {if $motor == 'paypal'}
                                    <p><strong>$ {$total / 1000 } USD</strong></p>
                                {/if}
                                {if $motor == 'webpay'}
                                    <p><strong>$ {$total|number_format:0:',':'.'}</strong></p>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="col-12 text-center mt-5">
                    <p style="font-size: 13px;">Se ha enviado automáticamente un comprobante de pago a tu correo electrónico {$usuario}</p>
                </div>
            </div>
        </div>
    </div>


</div>