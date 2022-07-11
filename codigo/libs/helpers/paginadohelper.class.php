<?php

class PaginadoHelper {

	/**
	 * Función que nos permite paginar los listados muy largas.
	 *
	 */
	public static function Paginado($pPaginaActual, $pCantList, $pTotalNoticias, $p_Url = '', $pSitio = 'full', $pSeccion = 0) {
		$pPaginaActual = (integer) $pPaginaActual;
		$pCantList = (integer) $pCantList;
		$pTotalNoticias = (integer) $pTotalNoticias;
		$pSeccion = (integer) $pSeccion;

		if ($p_Url != '') {
			$p_Url = $p_Url . '&amp;';
		}

		if ($pCantList >= 0 && $pTotalNoticias >= 0) {

			$pSaltos = ceil($pTotalNoticias / $pCantList); //ceil — Redondear fracciones hacia arriba

			if ($pPaginaActual >= $pSaltos) {//mayor a salto;
				$pPaginaActual = $pSaltos;
				$pPrevious = $pSaltos - 1;
				$pNext = $pSaltos + 1;
			} elseif ($pPaginaActual <= 0) {//menor a 0
				$pPaginaActual = 1;
				$pPrevious = 0;
				$pNext = 2;
			} else {//normal
				$pPrevious = $pPaginaActual - 1;
				$pNext = $pPaginaActual + 1;
			}

			$pagina_antes = $pPaginaActual - 2;
			$pagina_despues = $pPaginaActual + 2;

			$html = '';
			$href_l = '';
			$href_r = '';


			$href_l = "page={$pPrevious}";
			$href_r = "page={$pNext}";

			switch ($pSitio) {
				case 'Front':
					if ($pPrevious > 0) {// Volver
						$html .= "<div class='left'><a href='?";
						$html .= ( $pSeccion != 0) ? "link={$pSeccion}&amp;" : '';
						$html .= "{$href_l}'>« "._("Volver página")."</a></div>";
					} else {
						$html .= "<div class='left'>« "._("Volver página")."</div>";
					}
					$html .= "<div class='center'>";
					for ($i = 1; $i <= $pSaltos; $i++) {// números al medio
						if ($pPaginaActual == $i) {
							$html .= $i;
						} else {
							$html .= "<a href='?";
							$html .= ($pSeccion != 0) ? "link={$pSeccion}&" : '';
							$html .= "page={$i}'>{$i}</a> ";
						}
						if ($pSaltos != $i) {
							$html .= ' - ';
						}
					}
					$html .= "</div>";
					if ($pNext <= $pSaltos) {// Siguiente
						$html .= "<div class='right'><a href='?";
						$html .= ( $pSeccion != 0) ? "link={$pSeccion}&amp;" : '';
						$html .= "{$href_r}'>"._("Siguiente página")." »</a></div>";
					} else {
						$html .= "<div class='right'>"._("Siguiente página")." »</div>";
					}
					break;
				case 'Admin':
					// volver
					if ($pPrevious > 0) {
						$html .= "<li class='next'><a href='?{$p_Url}{$href_l}'>« "._("Volver")."</a></li>" . PHP_EOL;
					} else {
						$html .= "<li class='previous-off'>« "._("Volver")." </li>" . PHP_EOL;
					}
					// números al medio
					for ($i = 1; $i < $pSaltos + 1; $i++) {
						if ($pPaginaActual == $i) {
							$html .= "\t\t\t\t\t\t<li class='active'>{$i}</li>" . PHP_EOL;
						} else {
							$html .= "\t\t\t\t\t\t<li><a href='?{$p_Url}page={$i}'>{$i}</a></li>" . PHP_EOL;
						}
					}
					// Siguiente
					if ($pNext <= $pSaltos) {
						$html .= "\t\t\t\t\t\t<li class='next'><a href='?{$p_Url}{$href_r}'>"._("Siguiente")." »</a></li>" . PHP_EOL;
					} else {
						$html .= "\t\t\t\t\t\t<li  class='previous-off'>"._("Siguiente")." »</li>" . PHP_EOL;
					}
					break;
				case 'full':
					if ($pSaltos > 1) {
						// volver
						if ($pPrevious > 0) {
							//	$html .= "\t\t\t\t\t\t<li class='next'>Paginas de {$pPaginaActual} hasta {$pSaltos} </li>" . PHP_EOL;
							$html .= "<li class='next'><a href='?{$p_Url}{$href_l}'>« "._("Volver")."</a></li>" . PHP_EOL;
							if ($pagina_antes > 1) {
								$html .= "\t\t\t\t\t\t<li class='next'><a href='?{$p_Url}page=1'>1</a></li>" . PHP_EOL;
							} else {
								$html .= "\t\t\t\t\t\t<li  class='previous-off'>1</li>" . PHP_EOL;
							}
							
							$html .= "\t\t\t\t\t\t<li  class='previous-off'>...</li>" . PHP_EOL;
						} else {
							$html .= "<li class='previous-off'>« Volver </li>" . PHP_EOL;
							$html .= "\t\t\t\t\t\t<li  class='previous-off'>1</li>" . PHP_EOL;
						}
						// números al medio
						for ($i = 1; $i < $pSaltos + 1; $i++) {
							if ($pagina_antes <= $i && $pagina_despues >= $i) {
								if ($pPaginaActual == $i) {
									$html .= "\t\t\t\t\t\t<li class='active'>{$i}</li>" . PHP_EOL;
								} else {
									$html .= "\t\t\t\t\t\t<li><a href='?{$p_Url}page={$i}'>{$i}</a></li>" . PHP_EOL;
								}
							}
						}
						// Siguiente
						if ($pNext < $pSaltos) {
							$html .= "\t\t\t\t\t\t<li  class='previous-off'>...</li>" . PHP_EOL;
							if ($pagina_despues <= $pSaltos) {
								$html .= "\t\t\t\t\t\t<li class='next'><a href='?{$p_Url}page={$pSaltos}'>{$pSaltos}</a></li>" . PHP_EOL;
							} else {
								$html .= "\t\t\t\t\t\t<li  class='previous-off'>{$pSaltos}</li>" . PHP_EOL;
							}
							$html .= "\t\t\t\t\t\t<li class='next'><a href='?{$p_Url}{$href_r}'>"._("Siguiente")." »</a></li>" . PHP_EOL;
						} else {
							$html .= "\t\t\t\t\t\t<li  class='previous-off'>Siguiente »</li>" . PHP_EOL;
							$html .= "\t\t\t\t\t\t<li  class='previous-off'>{$pSaltos}</li>" . PHP_EOL;
						}
					} else {
						$html ='';
					}
					break;
			}

			return $html;
		}
		return false;
	}

	/**
	 * Devuelve le cantidad de refitros de la tabla 
	 *
	 */
	public static function getCount($p_tabla, $p_condicion = '') {
		/* @var $cnn MySql */
		$cnn = Registry::getInstance()->DbConn;

		if ($p_condicion != '') {
			$p_condicion = 'WHERE ' . $p_condicion;
		}

		$cantidad = $cnn->Select_Fila("SELECT COUNT(*) as Cantidad FROM {$p_tabla} {$p_condicion}");

		if ($cantidad === false) { // devuelve el error si algo fallo con MySql
			echo $cnn->get_Error(Registry::getInstance()->general['debug']);
		}

		return (integer) $cantidad['Cantidad'];
	}

}
