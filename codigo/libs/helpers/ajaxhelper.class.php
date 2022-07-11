<?php

class AjaxHelper {

	public static function IsXhr() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
				$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
			return true;
		}
		return false;

		// return @ $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
	}

	public static function armarScriptAutocompletar($p_Id, $p_minLength, $p_Caso) {
		$retorno = '		
        <script>
	       	$(document).ready(function(){ 	
				$( "#' . $p_Id . '" ).autocomplete({
      				source: "modulos/modulo_bucar_en_db.ajax.php?caso=' . $p_Caso . '",
      				minLength: ' . $p_minLength . '
    			});    			    		
			});
        </script>';
		return $retorno;
	}

}
