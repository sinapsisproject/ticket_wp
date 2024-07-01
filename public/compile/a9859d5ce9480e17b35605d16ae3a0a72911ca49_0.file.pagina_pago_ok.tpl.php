<?php
/* Smarty version 4.4.1, created on 2024-06-29 06:36:40
  from 'C:\wamp64\www\sinapsis\wp-content\plugins\congreso_wp\public\partials\pagina_pago_ok.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.4.1',
  'unifunc' => 'content_667fab784c2476_20362323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a9859d5ce9480e17b35605d16ae3a0a72911ca49' => 
    array (
      0 => 'C:\\wamp64\\www\\sinapsis\\wp-content\\plugins\\congreso_wp\\public\\partials\\pagina_pago_ok.tpl',
      1 => 1719642995,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_667fab784c2476_20362323 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp64\\www\\sinapsis\\wp-content\\plugins\\profile_wp\\public\\assets\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'C:\\wamp64\\www\\sinapsis\\wp-content\\plugins\\profile_wp\\public\\assets\\smarty\\libs\\plugins\\modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
?>
<div class="row">
    <div class="col-12 text-center title-pay-ok">
        <i class="fa-solid fa-circle-check"></i>
        <h1>¡Pago Exitoso!</h1>
    </div>

    <div class="row mt-3 mb-4 shadow box-detail-pay">
        <div class="col-12">
            <div class="row">
                <div class="col-12 mb-4 text-center">
                    <p style="font-size: 30px; font-weight: bold; margin-bottom: 2px;">Nº de orden: <?php echo $_smarty_tpl->tpl_vars['order']->value;?>
</p>
                    <p><i style="margin-right: 10px;" class="fa-solid fa-calendar-days"></i> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['fecha']->value,"%d-%m-%Y");?>
</p>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-12 col-md-7 text-center">
                        <p style="font-size: 20px;">Detalle de tu compra:</p>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="row">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['productos']->value, 'producto');
$_smarty_tpl->tpl_vars['producto']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['producto']->value) {
$_smarty_tpl->tpl_vars['producto']->do_else = false;
?>
                            <div class="col-6 text-start">
                                <p><?php echo $_smarty_tpl->tpl_vars['producto']->value->nombre_producto;?>
</p>
                            </div>
                            <div class="col-6 text-end">
                                <?php if ($_smarty_tpl->tpl_vars['motor']->value == 'paypal') {?>
                                <p>$ <?php echo $_smarty_tpl->tpl_vars['producto']->value->precio/1000;?>
 USD</p>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['motor']->value == 'webpay') {?>
                                <p>$ <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['producto']->value->precio,0,',','.');?>
</p>
                                <?php }?>
                            </div>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <hr>
                            <div class="col-6 text-start">
                                <p><strong>Total:</strong></p>
                            </div>
                            <div class="col-6 text-end">
                                <?php if ($_smarty_tpl->tpl_vars['motor']->value == 'paypal') {?>
                                    <p><strong>$ <?php echo $_smarty_tpl->tpl_vars['total']->value/1000;?>
 USD</strong></p>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['motor']->value == 'webpay') {?>
                                    <p><strong>$ <?php echo smarty_modifier_number_format($_smarty_tpl->tpl_vars['total']->value,0,',','.');?>
</strong></p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="col-12 text-center mt-5">
                    <p style="font-size: 13px;">Se ha enviado automáticamente un comprobante de pago a tu correo electrónico <?php echo $_smarty_tpl->tpl_vars['usuario']->value;?>
</p>
                </div>
            </div>
        </div>
    </div>


</div><?php }
}
