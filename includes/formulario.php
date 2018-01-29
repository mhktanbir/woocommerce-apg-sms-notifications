<?php global $apg_sms_settings, $apg_sms, $wpml_activo; ?>

<div class="wrap woocommerce">
  <h2>
    <?php _e( 'APG SMS Notifications Options.', 'woocommerce-apg-sms-notifications' ); ?>
  </h2>
  <?php 
	$tab = 1;
	
	//WPML
	if ( function_exists( 'icl_register_string' ) || !$wpml_activo ) { //Versión anterior a la 3.2
		$mensaje_pedido		= ( $wpml_activo ) ? icl_translate( 'apg_sms', 'mensaje_pedido', $apg_sms_settings['mensaje_pedido'] ) : $apg_sms_settings['mensaje_pedido'];
		$mensaje_recibido	= ( $wpml_activo ) ? icl_translate( 'apg_sms', 'mensaje_recibido', $apg_sms_settings['mensaje_recibido'] ) : $apg_sms_settings['mensaje_recibido'];
		$mensaje_procesando	= ( $wpml_activo ) ? icl_translate( 'apg_sms', 'mensaje_procesando', $apg_sms_settings['mensaje_procesando'] ) : $apg_sms_settings['mensaje_procesando'];
		$mensaje_completado	= ( $wpml_activo ) ? icl_translate( 'apg_sms', 'mensaje_completado', $apg_sms_settings['mensaje_completado'] ) : $apg_sms_settings['mensaje_completado'];
		$mensaje_nota		= ( $wpml_activo ) ? icl_translate( 'apg_sms', 'mensaje_nota', $apg_sms_settings['mensaje_nota'] ) : $apg_sms_settings['mensaje_nota'];
	} else if ( $wpml_activo ) { //Versión 3.2 o superior
		$mensaje_pedido		= apply_filters( 'wpml_translate_single_string', $apg_sms_settings['mensaje_pedido'], 'apg_sms', 'mensaje_pedido' );
		$mensaje_recibido	= apply_filters( 'wpml_translate_single_string', $apg_sms_settings['mensaje_recibido'], 'apg_sms', 'mensaje_recibido' );
		$mensaje_procesando	= apply_filters( 'wpml_translate_single_string', $apg_sms_settings['mensaje_procesando'], 'apg_sms', 'mensaje_procesando' );
		$mensaje_completado	= apply_filters( 'wpml_translate_single_string', $apg_sms_settings['mensaje_completado'], 'apg_sms', 'mensaje_completado' );
		$mensaje_nota		= apply_filters( 'wpml_translate_single_string', $apg_sms_settings['mensaje_nota'], 'apg_sms', 'mensaje_nota' );
	}
  ?>
  <h3><a href="<?php echo $apg_sms['plugin_url']; ?>" title="Art Project Group"><?php echo $apg_sms['plugin']; ?></a></h3>
  <p>
    <?php _e( 'Add to WooCommerce the possibility to send <abbr title="Short Message Service" lang="en">SMS</abbr> notifications to the client each time you change the order status. Notifies the owner, if desired, when the store has a new order. You can also send customer notes.', 'woocommerce-apg-sms-notifications' ); ?>
  </p>
  <?php include( 'cuadro-informacion.php' ); ?>
  <form method="post" action="options.php">
    <?php settings_fields( 'apg_sms_settings_group' ); ?>
    <div class="cabecera"> <a href="<?php echo $apg_sms['plugin_url']; ?>" title="<?php echo $apg_sms['plugin']; ?>" target="_blank"><img src="<?php echo plugins_url( '../assets/images/cabecera.jpg', __FILE__ ); ?>" class="imagen" alt="<?php echo $apg_sms['plugin']; ?>" /></a> </div>
    <table class="form-table apg-table">
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[servicio]">
            <?php _e( '<abbr title="Short Message Service" lang="en">SMS</abbr> gateway:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Select your SMS gateway', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><select class="wc-enhanced-select servicio" id="apg_sms_settings[servicio]" name="apg_sms_settings[servicio]" style="width: 450px;" tabindex="<?php echo $tab++; ?>">
            <?php
			$proveedores = array( 
				"voipstunt" 		=> "VoipStunt", 
				"voipbusterpro" 	=> "VoipBusterPro", 
				"voipbuster" 		=> "VoipBuster", 
				"smsdiscount" 		=> "SMS Discount", 
				"sipdiscount" 		=> "SIP Discount", 
				"solutions_infini" 	=> "Solutions Infini", 
				"twilio" 			=> "Twilio", 
				"clickatell" 		=> "Clickatell", 
				"clockwork" 		=> "Clockwork", 
				"bulksms" 			=> "BulkSMS", 
				"open_dnd" 			=> "OPEN DND", 
				"msg91" 			=> "MSG91", 
				"mvaayoo" 			=> "mVaayoo", 
				"esebun" 			=> "Esebun Business ( Enterprise & Developers only )",
				"isms" 				=> "iSMS Malaysia",
				"smslane" 			=> "SMS Lane ( Transactional SMS only )",
				"smscountry" 		=> "SMS Country",
				"labsmobile" 		=> "LabsMobile Spain",
				"plivo" 			=> "Plivo",
				"springedge" 		=> "Spring Edge",
				"moreify" 			=> "Moreify",
				"nexmo"				=> "Nexmo",
				"twizo"				=> "Twizo",
				"msgwow"			=> "MSGWOW",
			);
			asort( $proveedores, SORT_NATURAL | SORT_FLAG_CASE ); //Ordena alfabeticamente los proveedores
			$chequeado = false;
            foreach ( $proveedores as $valor => $proveedor ) {
				if ( isset( $apg_sms_settings['servicio'] ) && $apg_sms_settings['servicio'] == $valor ) {
					$chequea	= ' selected="selected"';
					$chequeado	= true;
				} else {
					$chequea	= '';
				}
				//$texto = ( $valor == "twizo" && !$chequeado ) ? ' selected="selected"' : '';
				echo '<option value="' . $valor . '"' . $chequea . '>' . $proveedor . '</option>' . PHP_EOL;
            }
            ?>
          </select></td>
      </tr>
      <?php             
		$proveedores_campos = array( 
			"voipstunt"			=> array( 
				"usuario_voipstunt" 				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_voipstunt" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			), 
			"voipbusterpro"		=> array( 
				"usuario_voipbusterpro"				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_voipbusterpro"			=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			), 
			"voipbuster"		=> array( 
				"usuario_voipbuster" 				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_voipbuster"				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			), 
			"smsdiscount"		=> array( 
				"usuario_smsdiscount" 				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_smsdiscount"			=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			), 
			"sipdiscount"		=> array( 
				"usuario_sipdiscount" 				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_sipdiscount"			=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			), 
			"solutions_infini" 	=> array( 
				"clave_solutions_infini" 			=> __( 'key', 'woocommerce-apg-sms-notifications' ),
				"identificador_solutions_infini" 	=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"twilio" 			=> array( 
				"clave_twilio" 						=> __( 'account Sid', 'woocommerce-apg-sms-notifications' ),
				"identificador_twilio" 				=> __( 'authentication Token', 'woocommerce-apg-sms-notifications' ),
				"telefono_twilio" 					=> __( 'mobile number', 'woocommerce-apg-sms-notifications' ),
			),
			"clickatell" 		=> array( 
				"identificador_clickatell" 			=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
				"usuario_clickatell" 				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_clickatell" 			=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			),
			"clockwork" 		=> array( 
				"identificador_clockwork" 			=> __( 'key', 'woocommerce-apg-sms-notifications' ),
			),
			"bulksms" 			=> array( 
				"usuario_bulksms" 					=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_bulksms" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"servidor_bulksms"					=> __( 'host', 'woocommerce-apg-sms-notifications' ),
			),
			"open_dnd" 			=> array( 
				"identificador_open_dnd" 			=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
				"usuario_open_dnd" 					=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_open_dnd" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
			),
			"msg91" 			=> array( 
				"clave_msg91" 						=> __( 'authentication key', 'woocommerce-apg-sms-notifications' ),
				"identificador_msg91" 				=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
				"ruta_msg91" 						=> __( 'route', 'woocommerce-apg-sms-notifications' ),
			),
			"mvaayoo" 			=> array( 
				"usuario_mvaayoo" 					=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_mvaayoo" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"identificador_mvaayoo" 			=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"esebun" 			=> array( 
				"usuario_esebun" 					=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_esebun" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"identificador_esebun" 				=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"isms" 				=> array( 
				"usuario_isms" 						=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_isms" 					=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"telefono_isms" 					=> __( 'mobile number', 'woocommerce-apg-sms-notifications' ),
			),
			"smslane" 			=> array( 
				"usuario_smslane" 					=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_smslane" 				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"sid_smslane" 						=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"smscountry" 		=> array( 
				"usuario_smscountry"				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_smscountry" 			=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"sid_smscountry" 					=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"labsmobile"       => array(
				"identificador_labsmobile"			=> __( 'client', 'woocommerce-apg-sms-notifications' ),
				"usuario_labsmobile"				=> __( 'username', 'woocommerce-apg-sms-notifications' ),
				"contrasena_labsmobile"				=> __( 'password', 'woocommerce-apg-sms-notifications' ),
				"sid_labsmobile"					=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"plivo"				=> array(
				"usuario_plivo"						=> __( 'authentication ID', 'woocommerce-apg-sms-notifications' ),
				"clave_plivo"						=> __( 'authentication Token', 'woocommerce-apg-sms-notifications' ),
				"identificador_plivo"				=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"springedge" 		=> array( 
				"clave_springedge" 					=> __( 'key', 'woocommerce-apg-sms-notifications' ),
				"identificador_springedge"		 	=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
			),
			"moreify" 			=> array( 
				"proyecto_moreify"					=> __( 'project', 'woocommerce-apg-sms-notifications' ),
				"identificador_moreify" 			=> __( 'authentication Token', 'woocommerce-apg-sms-notifications' ),
			),
			"nexmo" 			=> array( 
 				"clave_nexmo"						=> __( 'key', 'woocommerce-apg-sms-notifications' ),
				"identificador_nexmo"				=> __( 'authentication Token', 'woocommerce-apg-sms-notifications' ),
			),
			"twizo" 			=> array( 
 				"clave_twizo"						=> __( 'key', 'woocommerce-apg-sms-notifications' ),
 				"identificador_twizo"				=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
				"servidor_twizo"					=> __( 'host', 'woocommerce-apg-sms-notifications' ),
			),
			"msgwow" 			=> array( 
 				"clave_msgwow"						=> __( 'key', 'woocommerce-apg-sms-notifications' ),
 				"identificador_msgwow"				=> __( 'sender ID', 'woocommerce-apg-sms-notifications' ),
				"ruta_msgwow" 						=> __( 'route', 'woocommerce-apg-sms-notifications' ),
				"servidor_msgwow"					=> __( 'host', 'woocommerce-apg-sms-notifications' ),
			),
		);
		
		$proveedores_opciones = array(
			"ruta_msg91"		=> array(
				"default"				=> __( 'Default', 'woocommerce-apg-sms-notifications' ), 
				1						=> 1, 
				4						=> 4,
			),
			"servidor_bulksms"	=> array(
				"bulksms.vsms.net"		=> __( 'International', 'woocommerce-apg-sms-notifications' ), 
				"www.bulksms.co.uk"		=> __( 'UK', 'woocommerce-apg-sms-notifications' ),
				"usa.bulksms.com"		=> __( 'USA', 'woocommerce-apg-sms-notifications' ),
				"bulksms.2way.co.za"	=> __( 'South Africa', 'woocommerce-apg-sms-notifications' ),
				"bulksms.com.es"		=> __( 'Spain', 'woocommerce-apg-sms-notifications' ),
			),
			"servidor_twizo"	=> array(
				"api-asia-01.twizo.com"	=> __( 'Singapore', 'woocommerce-apg-sms-notifications' ), 
				"api-eu-01.twizo.com"	=> __( 'Germany', 'woocommerce-apg-sms-notifications' ), 
			),
			"ruta_msgwow"		=> array(
				1						=> 1, 
				4						=> 4,
			),
			"servidor_msgwow"	=> array(
				"0"						=> __( 'International', 'woocommerce-apg-sms-notifications' ), 
				"1"						=> __( 'USA', 'woocommerce-apg-sms-notifications' ), 
				"91"					=> __( 'India', 'woocommerce-apg-sms-notifications' ), 
			),
		);

		//Pinta los campos de los proveedores
		foreach ( $proveedores as $valor => $proveedor ) {
			foreach ( $proveedores_campos[$valor] as $valor_campo => $campo ) {
				if ( array_key_exists( $valor_campo, $proveedores_opciones ) ) { //Campo select
					echo '
      <tr valign="top" class="' . $valor . '"><!-- ' . $proveedor . ' -->
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[' . $valor_campo . ']">' .ucfirst( $campo ) . ':' . '</label>
          <span class="woocommerce-help-tip" data-tip="' . sprintf( __( 'The %s for your account in %s', 'woocommerce-apg-sms-notifications' ), $campo, $proveedor ) . '" src="' . plugins_url(  "woocommerce/assets/images/help.png" ) . '" height="16" width="16" /> </th>
        <td class="forminp forminp-number"><select class="wc-enhanced-select" id="apg_sms_settings[' . $valor_campo . ']" name="apg_sms_settings[' . $valor_campo . ']" tabindex="' . $tab++ . '">
					';
					foreach ( $proveedores_opciones[$valor_campo] as $valor_opcion => $opcion ) {
						$chequea = ( isset( $apg_sms_settings[$valor_campo] ) && $apg_sms_settings[$valor_campo] == $valor_opcion ) ? ' selected="selected"' : '';
				  		echo '<option value="' . $valor_opcion . '"' . $chequea . '>' . $opcion . '</option>' . PHP_EOL;
					}
					echo '          </select></td>
      </tr>
					';
				} else { //Campo input
					echo '
      <tr valign="top" class="' . $valor . '"><!-- ' . $proveedor . ' -->
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[' . $valor_campo . ']">' . ucfirst( $campo ) . ':' . '</label>
          <span class="woocommerce-help-tip" data-tip="' . sprintf( __( 'The %s for your account in %s', 'woocommerce-apg-sms-notifications' ), $campo, $proveedor ) . '" src="' . plugins_url(  "woocommerce/assets/images/help.png" ) . '" height="16" width="16" /> </th>
        <td class="forminp forminp-number"><input type="text" id="apg_sms_settings[' . $valor_campo . ']" name="apg_sms_settings[' . $valor_campo . ']" size="50" value="' . ( isset( $apg_sms_settings[$valor_campo] ) ? $apg_sms_settings[$valor_campo] : '' ) . '" tabindex="' . $tab++ . '" /></td>
      </tr>
					';
				}
			}
		}
      ?>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[telefono]">
            <?php _e( 'Your mobile number:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'The mobile number registered in your SMS gateway account and where you receive the SMS messages. You can add multiple mobile numbers separeted by | character. Example: xxxxxxxxx|yyyyyyyyy', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input type="text" id="apg_sms_settings[telefono]" name="apg_sms_settings[telefono]" size="50" value="<?php echo ( isset( $apg_sms_settings['telefono'] ) ? $apg_sms_settings['telefono'] : '' ); ?>" tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[notificacion]">
            <?php _e( 'New order notification:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( "Check if you want to receive a SMS message when there's a new order", 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input id="apg_sms_settings[notificacion]" name="apg_sms_settings[notificacion]" type="checkbox" value="1" <?php echo ( isset( $apg_sms_settings['notificacion'] ) && $apg_sms_settings['notificacion'] == "1" ? 'checked="checked"' : '' ); ?> tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[internacional]">
            <?php _e( 'Send international <abbr title="Short Message Service" lang="en">SMS</abbr>?:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Check if you want to send international SMS messages', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input id="apg_sms_settings[internacional]" name="apg_sms_settings[internacional]" type="checkbox" value="1" <?php echo ( isset( $apg_sms_settings['internacional'] ) && $apg_sms_settings['internacional'] == "1" ? 'checked="checked"' : '' ); ?> tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[envio]">
            <?php _e( 'Send <abbr title="Short Message Service" lang="en">SMS</abbr> to shipping mobile?:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Check if you want to send SMS messages to shipping mobile numbers, only if it is different from billing mobile number', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input id="apg_sms_settings[envio]" name="apg_sms_settings[envio]" type="checkbox" value="1" <?php echo ( isset( $apg_sms_settings['envio'] ) && $apg_sms_settings['envio'] == "1" ? 'checked="checked"' : '' ); ?> tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[productos]">
            <?php _e( 'order_product variable full details:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Check if you want to send the SMS messages with full order product information', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input id="apg_sms_settings[productos]" name="apg_sms_settings[productos]" type="checkbox" value="1" <?php echo ( isset( $apg_sms_settings['productos'] ) && $apg_sms_settings['productos'] == "1" ? 'checked="checked"' : '' ); ?> tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top" class="campo_envio">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[campo_envio]">
            <?php _e( 'Shipping mobile field:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Select the shipping mobile field', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><select id="apg_sms_settings[campo_envio]" name="apg_sms_settings[campo_envio]" class="wc-enhanced-select" tabindex="<?php echo $tab++; ?>">
        <?php
			$pais	= new WC_Countries();
			$campos	= $pais->get_address_fields( $pais->get_base_country(), 'shipping_' ); //Campos ordinarios
			$campos_personalizados = apply_filters( 'woocommerce_checkout_fields', array() );
			if ( isset( $campos_personalizados['shipping'] ) ) {
				$campos += $campos_personalizados['shipping'];
			}
            foreach ( $campos as $valor => $campo ) {
				$chequea = ( isset( $apg_sms_settings['campo_envio'] ) && $apg_sms_settings['campo_envio'] == $valor ) ? ' selected="selected"' : '';
				if ( isset( $campo['label'] ) ) {
					echo '<option value="' . $valor . '"' . $chequea . '>' . $campo['label'] . '</option>' . PHP_EOL;
				}
            }
		?>
        </select></td>
      </tr>
      <?php if ( class_exists( 'WC_SA' ) || function_exists( 'AppZab_woo_advance_order_status_init' ) || class_exists( 'WC_Order_Status_Manager' ) || isset( $GLOBALS['advorder_lite_orderstatus'] ) ) : //Comprueba la existencia de los plugins de estado personalizado ?>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[estados_personalizados]">
            <?php _e( 'Custom Order Statuses & Actions:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Select your own statuses.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><select multiple="multiple" class="wc-enhanced-select multiselect estados_personalizados" id="apg_sms_settings[estados_personalizados]" name="apg_sms_settings[estados_personalizados][]" style="width: 450px;" tabindex="<?php echo $tab++; ?>">
            <?php
				if ( class_exists( 'WC_SA' ) ) { //WooCommerce Order Status & Actions Manager
					$lista_de_estados_temporal = array();
					$lista_de_estados = wc_sa_get_statuses();
					print_r($lista_de_estados);
					foreach ( $lista_de_estados as $clave => $estado ) {
						if ( $estado->label ) {
							$estados_personalizados = new WC_SA_Status( $clave );
							if ( $estados_personalizados->email_notification ) {
								$chequea = '';
								if ( isset( $apg_sms_settings['estados_personalizados'] ) ) {
									foreach ( $apg_sms_settings['estados_personalizados'] as $estado_personalizado ) {
										if ( $estado_personalizado == $estado->label ) {
											$chequea = ' selected="selected"';
										}
									}
								}
								echo '<option value="' . $estado->label . '"' . $chequea . '>' . ucfirst( $estado->label ) . '</option>' . PHP_EOL;
							}
							$lista_de_estados_temporal[$clave] = $estado->label;
						}
					}
					$lista_de_estados = $lista_de_estados_temporal;
				} else {
					$estados_originales = array( 
						'pending',
						'failed',
						'on-hold',
						'processing',
						'completed',
						'refunded',
						'cancelled',
					);
					if ( isset( $GLOBALS['advorder_lite_orderstatus'] ) ) { //WooCommerce Advance Order Status
						$lista_de_estados = ( array ) $GLOBALS['advorder_lite_orderstatus']->get_terms( 'shop_order_status', array( 
							'hide_empty'	=> 0, 
							'orderby'		=> 'id' 
						) );
					} else if ( class_exists( 'WC_Order_Status_Manager' ) ) { //WooCommerce Order Status Manager
						$lista_de_estados = wc_order_status_manager_get_order_status_posts();
					} else {
						$lista_de_estados = ( array ) get_terms( 'shop_order_status', array( 
							'hide_empty'	=> 0, 
							'orderby'		=> 'id' 
						) );
					}
					$lista_nueva = array();
					if ( isset( $lista_de_estados) ) {
						foreach( $lista_de_estados as $estado ) {
							$estado_nombre = str_replace( "wc-", "", $estado->slug );
							if ( empty( $estado_nombre ) && class_exists( 'WC_Order_Status_Manager' ) ) { //WooCommerce Advance Order Status
								$estado_nombre = $estado->post_name;
							}
							if ( !in_array( $estado_nombre, $estados_originales ) ) {
								$muestra_estado = false;
								$estados_personalizados = get_option( 'taxonomy_' . $estado->term_id, false );
								if ( $estados_personalizados && ( isset( $estados_personalizados['woocommerce_woo_advance_order_status_email'] ) ) && (  '1' == $estados_personalizados['woocommerce_woo_advance_order_status_email'] || 'yes' == $estados_personalizados['woocommerce_woo_advance_order_status_email'] ) ) {
									$muestra_estado = true;
								}
								if ( get_option( 'az_custom_order_status_meta_' . $estado->slug, true ) ) { //WooCommerce Advance Order Status
									$estados_personalizados = get_option( 'az_custom_order_status_meta_' . $estado->slug, true );
									if ( $estados_personalizados ) { //Ya no hay que controlar si se notifica por correo electrónico o no
										$muestra_estado = true;
									}
								}
								if ( class_exists( 'WC_Order_Status_Manager' ) ) { //WooCommerce Advance Order Status
									$estado->name	= $estado->post_title;
									$muestra_estado	= true;
								}
								if ( $muestra_estado ) {
									$chequea = '';
									if ( isset( $apg_sms_settings['estados_personalizados'] ) ) {
										foreach ( $apg_sms_settings['estados_personalizados'] as $estado_personalizado ) {
											if ( $estado_personalizado == $estado_nombre ) {
												$chequea = ' selected="selected"';
											}
										}
									}
									echo '<option value="' . $estado_nombre . '"' . $chequea . '>' . $estado->name . '</option>' . PHP_EOL;
									$lista_nueva[] = $estado_nombre;
								}
							}
						}
					}
					$lista_de_estados = $lista_nueva;
				}
            ?>
          </select></td>
      </tr>
      <?php foreach ( $lista_de_estados as $estados_personalizados ) : ?>
      <tr valign="top" class="<?php echo $estados_personalizados; ?>"><!-- <?php echo ucfirst( $estados_personalizados ); ?> -->
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[<?php echo $estados_personalizados; ?>]"> <?php echo sprintf( __( '%s state custom message:', 'woocommerce-apg-sms-notifications' ), ucfirst( $estados_personalizados ) ); ?> </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[<?php echo $estados_personalizados; ?>]" name="apg_sms_settings[<?php echo $estados_personalizados; ?>]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( isset( $apg_sms_settings[$estados_personalizados] ) ? $apg_sms_settings[$estados_personalizados] : "" ); ?></textarea></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[variables]">
            <?php _e( 'Custom variables:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can add your own variables. Each variable must be entered onto a new line without percentage character ( % ). Example: <code>_custom_variable_name</code><br /><code>_another_variable_name</code>.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[variables]" name="apg_sms_settings[variables]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( isset( $apg_sms_settings['variables'] ) ? $apg_sms_settings['variables'] : '' ); ?></textarea></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[productos]">
            <?php _e( 'Send only this messages:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Select what messages do you want to send', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number">
        <select multiple="multiple" class="wc-enhanced-select multiselect mensajes" id="apg_sms_settings[mensajes]" name="apg_sms_settings[mensajes][]" style="width: 450px;" tabindex="<?php echo $tab++; ?>">
        <?php
			$mensajes = array(
				'todos'					=> __( 'All messages', 'woocommerce-apg-sms-notifications' ),
				'mensaje_pedido'		=> __( 'Owner custom message', 'woocommerce-apg-sms-notifications' ),
				'mensaje_recibido'		=> __( 'Order received custom message', 'woocommerce-apg-sms-notifications' ),
				'mensaje_procesando'	=> __( 'Order processing custom message', 'woocommerce-apg-sms-notifications' ),
				'mensaje_completado'	=> __( 'Order completed custom message', 'woocommerce-apg-sms-notifications' ),
				'mensaje_nota'			=> __( 'Notes custom message', 'woocommerce-apg-sms-notifications' ),
			);
			$chequeado = false;
			foreach ( $mensajes as $valor => $mensaje ) {
				if ( isset( $apg_sms_settings['mensajes'] ) && in_array( $valor, $apg_sms_settings['mensajes'] ) ) {
					$chequea	= ' selected="selected"';
					$chequeado	= true;
				} else {
					$chequea	= '';
				}
				$texto = ( !isset( $apg_sms_settings['mensajes'] ) && $valor == 'todos' && !$chequeado ) ? ' selected="selected"' : '';
				echo '<option value="' . $valor . '"' . $chequea . $texto . '>' . $mensaje . '</option>' . PHP_EOL;
			}
		?>
		</select>
      </tr>
      <tr valign="top" class="mensaje_pedido">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[mensaje_pedido]">
            <?php _e( 'Owner custom message', 'woocommerce-apg-sms-notifications' ); ?>:
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[mensaje_pedido]" name="apg_sms_settings[mensaje_pedido]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( !empty( $mensaje_pedido ) ? $mensaje_pedido : sprintf( __( "Order No. %s received on ", 'woocommerce-apg-sms-notifications' ), "%id%" ) . "%shop_name%" . "." ); ?></textarea></td>
      </tr>
      <tr valign="top" class="mensaje_recibido">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[mensaje_recibido]">
            <?php _e( 'Order received custom message', 'woocommerce-apg-sms-notifications' ); ?>:
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[mensaje_recibido]" name="apg_sms_settings[mensaje_recibido]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( !empty( $mensaje_recibido ) ? $mensaje_recibido : sprintf( __( 'Your order No. %s is received on %s. Thank you for shopping with us!', 'woocommerce-apg-sms-notifications' ), "%id%", "%shop_name%" ) ); ?></textarea></td>
      </tr>
      <tr valign="top" class="mensaje_procesando">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[mensaje_procesando]">
            <?php _e( 'Order processing custom message', 'woocommerce-apg-sms-notifications' ); ?>:
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[mensaje_procesando]" name="apg_sms_settings[mensaje_procesando]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( !empty( $mensaje_procesando ) ? $mensaje_procesando : sprintf( __( 'Thank you for shopping with us! Your order No. %s is now: ', 'woocommerce-apg-sms-notifications' ), "%id%" ) . __( 'Processing', 'woocommerce-apg-sms-notifications' ) . "." ); ?></textarea></td>
      </tr>
      <tr valign="top" class="mensaje_completado">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[mensaje_completado]">
            <?php _e( 'Order completed custom message', 'woocommerce-apg-sms-notifications' ); ?>:
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[mensaje_completado]" name="apg_sms_settings[mensaje_completado]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( !empty( $mensaje_completado ) ? $mensaje_completado : sprintf( __( 'Thank you for shopping with us! Your order No. %s is now: ', 'woocommerce-apg-sms-notifications' ), "%id%" ) . __( 'Completed', 'woocommerce-apg-sms-notifications' ) . "." ); ?></textarea></td>
      </tr>
      <tr valign="top" class="mensaje_nota">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[mensaje_nota]">
            <?php _e( 'Notes custom message', 'woocommerce-apg-sms-notifications' ); ?>:
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'You can customize your message. Remember that you can use this variables: %id%, %order_key%, %billing_first_name%, %billing_last_name%, %billing_company%, %billing_address_1%, %billing_address_2%, %billing_city%, %billing_postcode%, %billing_country%, %billing_state%, %billing_email%, %billing_phone%, %shipping_first_name%, %shipping_last_name%, %shipping_company%, %shipping_address_1%, %shipping_address_2%, %shipping_city%, %shipping_postcode%, %shipping_country%, %shipping_state%, %shipping_method%, %shipping_method_title%, %payment_method%, %payment_method_title%, %order_discount%, %cart_discount%, %order_tax%, %order_shipping%, %order_shipping_tax%, %order_total%, %status%, %prices_include_tax%, %tax_display_cart%, %display_totals_ex_tax%, %display_cart_ex_tax%, %order_date%, %modified_date%, %customer_message%, %customer_note%, %post_status%, %shop_name%, %order_product% and %note%.', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><textarea id="apg_sms_settings[mensaje_nota]" name="apg_sms_settings[mensaje_nota]" cols="50" rows="5" tabindex="<?php echo $tab++; ?>"><?php echo stripcslashes( !empty( $mensaje_nota ) ? $mensaje_nota : sprintf( __( 'A note has just been added to your order No. %s: ', 'woocommerce-apg-sms-notifications' ), "%id%" ) . "%note%" ); ?></textarea></td>
      </tr>
      <tr valign="top">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[debug]">
            <?php _e( 'Send debug information?:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Check if you want to receive debug information from your SMS gateway', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input id="apg_sms_settings[debug]" name="apg_sms_settings[debug]" type="checkbox" class="debug" value="1" <?php echo ( isset( $apg_sms_settings['debug'] ) && $apg_sms_settings['debug'] == "1" ? 'checked="checked"' : '' ); ?> tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
      <tr valign="top" class="campo_debug">
        <th scope="row" class="titledesc"> <label for="apg_sms_settings[campo_debug]">
            <?php _e( 'email address:', 'woocommerce-apg-sms-notifications' ); ?>
          </label>
          <span class="woocommerce-help-tip" data-tip="<?php _e( 'Add an email address where you want to receive the debug information', 'woocommerce-apg-sms-notifications' ); ?>"></span> </th>
        <td class="forminp forminp-number"><input type="text" id="apg_sms_settings[campo_debug]" name="apg_sms_settings[campo_debug]" size="50" value="<?php echo ( isset( $apg_sms_settings['campo_debug'] ) ? $apg_sms_settings['campo_debug'] : '' ); ?>" tabindex="<?php echo $tab++; ?>" /></td>
      </tr>
    </table>
    <p class="submit">
      <input class="button-primary" type="submit" value="<?php _e( 'Save Changes', 'woocommerce-apg-sms-notifications' ); ?>"  name="submit" id="submit" tabindex="<?php echo $tab++; ?>" />
    </p>
  </form>
</div>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
	//Cambia los campos en función del proveedor de servicios SMS
	$( '.servicio' ).on( 'change', function () { 
		control( $( this ).val() ); 
	} );
	var control = function( capa ) {
		if ( capa == '' ) {
			capa = $( '.servicio option:selected' ).val();
		}
		var proveedores= new Array();
		<?php 
		foreach( $proveedores as $indice => $valor ) {
			echo "proveedores['$indice'] = '$valor';" . PHP_EOL;
		}
		?>
		
		for ( var valor in proveedores ) {
    		if ( valor == capa ) {
				$( '.' + capa ).show();
			} else {
				$( '.' + valor ).hide();
			}
		}
	};
	control( $( '.servicio' ).val() );

	//Cambia los campos en función de los mensajes seleccionados
	$( '.mensajes' ).on( 'change', function () { 
		control_mensajes( $( this ).val() ); 
	} );
	var control_mensajes = function( capa ) {
		if ( capa == '' ) {
			capa = $( '.mensajes option:selected' ).val();
		}

		var mensajes= new Array();
		<?php 
		foreach( $mensajes as $indice => $valor ) {
			echo "mensajes['$indice'] = '$valor';" . PHP_EOL; 
		}
		?>

		for ( var valor in mensajes ) {
			$( '.' + valor ).hide();
			for ( var valor_capa in capa ) {
				if ( valor == capa[valor_capa] || capa[valor_capa] == 'todos' ) {
					$( '.' + valor ).show();
				}
			}
		}
	};
	
	$( '.mensajes' ).each( function( i, selected ) { 
	  control_mensajes( $( selected ).val() );
	} );
	
	if ( typeof chosen !== 'undefined' && $.isFunction( chosen ) ) {
		jQuery( "select.chosen_select" ).chosen();
	}
	
	//Controla el campo de teléfono del formulario de envío
	$( '.campo_envio' ).hide();
	$( '.envio' ).on( 'change', function () { 
		control_envio( '.envio' ); 
	} );
	var control_envio = function( capa ) {
		if ( $( capa ).is(':checked') ){
			$( '.campo_envio' ).show();
		} else {
			$( '.campo_envio' ).hide();
		}
	};
	control_envio( '.envio' ); 
	
	//Controla el campo de correo electrónico del formulario de envío
	$( '.campo_debug' ).hide();
	$( '.debug' ).on( 'change', function () { 
		control_debug( '.debug' ); 
	} );
	var control_debug = function( capa ) {
		if ( $( capa ).is(':checked') ){
			$( '.campo_debug' ).show();
		} else {
			$( '.campo_debug' ).hide();
		}
	};
	control_debug( '.debug' ); 
	
<?php if ( class_exists( 'WC_SA' ) || function_exists( 'AppZab_woo_advance_order_status_init' ) || class_exists( 'WC_Order_Status_Manager' ) || isset( $GLOBALS['advorder_lite_orderstatus'] ) ) : //Comprueba la existencia de los plugins de estado personalizado ?>
	//Cambia los campos en función de los estados personalizados seleccionados
	$( '.estados_personalizados' ).on( 'change', function () { 
		control_personalizados( $( this ).val() ); 
	} );
	var control_personalizados = function( capa ) {
		var estados= new Array();
		<?php 
		foreach( $lista_de_estados as $valor ) {
			echo "estados['$valor'] = '$valor';" . PHP_EOL; 
		}
		?>

		for ( var valor in estados ) {
			$( '.' + valor ).hide();
			for ( var valor_capa in capa ) {
				if ( valor == capa[valor_capa] ) {
					$( '.' + valor ).show();
				}
			}
		}
	};

	$( '.estados_personalizados' ).each( function( i, selected ) { 
	  control_personalizados( $( selected ).val() );
	} );
<?php endif; ?>	
} );
</script> 
