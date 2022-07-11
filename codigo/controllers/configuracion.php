<?php

SeguridadHelper::Pasar(90);

$T_Titulo = _('Configuración General');
$T_Script = 'configuracion';
$Item_Name = 'configuracion';
$T_Link = '';
$T_Error = array();
$T_Mensaje = '';

$T_Tipo = (isset($_REQUEST['tipo'])) ? $_REQUEST['tipo'] : '';
$T_Pregunta = (isset($_POST['pregunta'])) ? $_POST['pregunta'] : array();

//echo"<pre>";	print_r($T_Pregunta);echo"</pre>";

if ($T_Tipo=='save') {
	foreach ($T_Pregunta as $T_Id => $valor) {

		$o_Config = Config_L::obtenerPorId($T_Id);
		$preg_post = $T_Pregunta[$T_Id];
		if($o_Config->getTipo()=='si_no'){
				if($preg_post=='on'){
						$valor='1';$preg_post='1';
				}else{
						$valor='0';$preg_post='0';
				}
				//echo $T_Id.'='.$preg_post.'<br>';
		}
		$valor_table = $o_Config->getValor();
		
		if ($preg_post != $valor_table) {
			$o_Config->setValor($valor);
			//echo $T_Id.'='.$valor.'<br>';
			if (!$o_Config->save(Registry::getInstance()->general['debug'])) {
				$T_Error['e' . $T_Id] = $o_Config->getErrores();
			} else {
				SeguridadHelper::Reporte(Registry::getInstance()->Usuario->getId(), $T_Titulo . '-' . $a_Acciones[1], 'Tabla - ' . $T_Script . ' Id - ' . $o_Config->getId());

				if ($o_Config->getParametro() == 'backup') {
					if (!file_exists($rutaBackup . '/no_borrar.aux')) {
						$resultado = SOHelper::umountRed(Config_L::p('backup'));
						if ($resultado != array()) {
							$T_Error = implode(' ', $resultado);
						}
					}
				}



			}
		}
	}
	if (count($T_Error) == 0) {
		$T_Mensaje = _('Los combios fue modificados con éxito.');
	}
}

$o_ListadoSecciones = Config_L::obtenerSecciones();

