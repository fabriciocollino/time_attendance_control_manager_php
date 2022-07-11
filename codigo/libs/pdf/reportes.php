<?php
define('K_PATH_IMAGES', '');

require_once(APP_PATH . '/libs/pdf/tfpdf.php');

require_once(APP_PATH . '/libs/pdf/tfpdfmulticell.php');

require_once(APP_PATH . '/libs/pdf/tcpdf.php');

class PDF extends tFPDF {

	var $dias;
	var $meses;
	var $titulo;

	function setDias($valor) {
		$this->dias = $valor;
	}

	function setMeses($valor) {
		$this->meses = $valor;
	}

	function setTitulo($valor) {
		$this->titulo = $valor;
	}

	// Cabecera de página
	function Header() {

		// Logo
		/* if (file_exists(Config_L::obtenerPorParametro("empresa_logo")->getValor()))
		  $this->Image(Config_L::obtenerPorParametro("empresa_logo")->getValor(), 10, 8, 33);
		  else
		  $this->Image('img/logo_pdf_square.png', 10, 8, 33);

		  // Arial bold 15
		  $this->SetFont('Arial', 'B', 15);
		  // Movernos a la derecha
		  $this->Cell(70);
		  // Título
		  $this->Cell(50, 10, 'Reportes ACSM', 0, 0, 'C');
		  // Salto de línea
		  $this->Ln(25); */

		if (file_exists(Config_L::obtenerPorParametro("empresa_logo")->getValor()))
			$this->Image(Config_L::obtenerPorParametro("empresa_logo")->getValor(), 10, 5, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		else
			$this->Image('img/logo_pdf_square.png', 10, 5, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

		$dia_actual = _('Generado el ') . $this->dias[date('w')] . " " . date('d') . " de " . $this->meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		$this->SetXY(45, 8);
		// Set font
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->Cell(0, 0, _('Reportes ACSM'), 0, 0);
		$this->Ln(4.3);
		$this->SetX(45);
		$this->SetFont('Arial', '', 10);
		$this->Cell(0, 0, $this->titulo, 0, 2, 'L');
		$this->Ln(4.3);
		$this->SetX(45);
		$this->Cell(0, 0, $dia_actual, 0, 0, 'L');
		$this->Ln(4.3);
		$this->SetX(45);
		$this->Cell(0, 0, $periodo, 0, 0, 'L');
		$this->Ln(4.3);
		$this->Line(10, 24, 206, 24);
		$this->Ln(5);
	}

	// Pie de página
	function Footer() {
		$this->Line(10, 282, 206, 282);
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		$this->Cell(0, 10, 'TekBox - www.tekbox.com.ar', 0, 0, 'C');
		// Arial italic 8
		$this->SetFont('Arial', '', 6);
		// Número de página
		$this->Cell(0, 10, _('Página') . ' ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
	}

	function Tabla($header, $data, $widths) {
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(60, 60, 60);
		$this->SetTextColor(255);
		$this->SetDrawColor(60, 60, 60);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial', 'B', 11);

		if (count($widths) != count($header))
			die(_("Datos de la tabla erróneos."));

		// Cabecera
		$w = $widths;
		for ($i = 0; $i < count($header); $i++) {
			//$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', true);
		}
		$this->Ln();

		// Restauración de colores y fuentes
		$this->SetFillColor(239, 242, 255);
		$this->SetTextColor(0);
		$this->SetFont('Times', '', 10);

		// Datos
		$fill = false;
		foreach ($data as $row) {

			for ($i = 0; $i < count($header); $i++) {
				//$this->Cell($w[$i],6,$row[$i],'LR',0,'L',$fill);
				//$this->Cell($w[$i],6,iconv('UTF-8', 'windows-1252', $row[$i]),'LR',0,'L',$fill);
				//parece que las cosas que vienen de la DB no necesitan ser convertidas. Pero si, las cosas que están escritas en el codigo
				$this->Cell($w[$i], 6, $row[$i], 'LR', 0, 'L', $fill);
			}
			$this->Ln();
			$fill = !$fill;
		}
		// Línea de cierre
		$this->Cell(array_sum($w), 0, '', 'T');
	}

	function TablaDoble($header, $rows, $widths, $aligns, $borders) {

		$oMulticell = new TfpdfMulticell($this);

		$oMulticell->setStyle("p", "Times", "", 10, "0,0,0");
		$oMulticell->setStyle("pb", "Times", "B", 10, "0,0,0");
		$oMulticell->setStyle("pi", "Times", "I", 11, "80,80,260");
		$oMulticell->setStyle("pu", "Times", "U", 11, "80,80,260");
		$oMulticell->setStyle("t1", "Arial", "", 11, "80,80,260");
		$oMulticell->setStyle("t3", "Times", "B", 14, "203,0,48");
		$oMulticell->setStyle("t4", "Arial", "BI", 11, "0,151,200");
		$oMulticell->setStyle("hh", "Times", "B", 11, "255,189,12");
		$oMulticell->setStyle("ss", "Arial", "", 7, "203,0,48");
		$oMulticell->setStyle("size", "Times", "BI", 13, "0,0,120");
		$oMulticell->setStyle("color", "Times", "BI", 13, "0,255,255");
		$oMulticell->setStyle("red", "Times", "", 10, "255,0,0");
		$oMulticell->setStyle("red9", "Times", "", 9, "255,0,0");
		$oMulticell->setStyle("smll", "Times", "", 9, "0,0,0");

		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(60, 60, 60);
		$this->SetTextColor(255);
		$this->SetDrawColor(60, 60, 60);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial', 'B', 11);

		if (count($widths) != count($header))
			die(_("Datos de la tabla erróneos."));

		// Cabecera
		$w = $widths;
		for ($i = 0; $i < count($header); $i++) {
			//$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
			$this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', true);
		}
		$this->Ln();

		// Restauración de colores y fuentes
		$this->SetFillColor(239, 242, 255);
		$this->SetTextColor(0);
		$this->SetFont('Times', '', 10);



		// Datos
		$fill = false;
		foreach ($rows as $data) {
			//Calculate the height of the row
			$nb = 0;
			for ($i = 0; $i < count($data); $i++) {
				$nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
			}
			$h = 5 * $nb;
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for ($i = 0; $i < count($data); $i++) {
				$w = $widths[$i];
				$a = isset($aligns[$i]) ? $aligns[$i] : 'L';
				$border = isset($borders[$i]) ? $borders[$i] : '0';
				//Save the current position
				$x = $this->GetX();
				$y = $this->GetY();
				//Draw the border
				//$this->Rect($x, $y, $w, $h);
				//Print the text
				//$this->MultiCell($w, 5, $data[$i], 'LR', $a,$fill);
				$oMulticell->multiCell($w, 5, $data[$i], $border, $a, $fill, 1);

				//Put the position to the right of the cell
				$this->SetXY($x + $w, $y);
			}
			//Go to the next line
			$this->Ln($h);
			$fill = !$fill;
		}


		// Línea de cierre
		$this->Cell(array_sum($widths), 0, '', 'T');
	}

//funciones para imprimir
	var $javascript;
	var $n_js;

	function IncludeJS($script) {
		$this->javascript = $script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js = $this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) ' . ($this->n + 1) . ' 0 R]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS ' . $this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_out('/Names <</JavaScript ' . ($this->n_js) . ' 0 R>>');
		}
	}

	function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w, $txt) {

		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;

		$s = str_replace("\r", '', $txt);

		return count($s) + 1;


		///por ahora no lo uso. esto fuerza los \n cuando no alcanza el W de la celda.


		$nb = strlen($s);

		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l+=$cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				}
				else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}

}

class MiPDF extends TCPDF {
	/* function Header() {

	  // Logo
	  if (file_exists(Config_L::obtenerPorParametro("empresa_logo")->getValor()))
	  $this->Image(Config_L::obtenerPorParametro("empresa_logo")->getValor(), 10, 8, 33);
	  else
	  $this->Image('img/logo_pdf_square.png', 10, 8, 33);

	  // Arial bold 15
	  $this->SetFont('helvetica', 'B', 15);
	  // Movernos a la derecha
	  $this->Cell(70);
	  // Título
	  $this->Cell(50, 10, 'Reportes ACSM', 0, 0, 'C');
	  // Salto de línea
	  $this->Ln(25);
	  }
	 */

	/* public function Header() {
	  // Logo
	  //$image_file = K_PATH_IMAGES . 'logo_example.jpg';
	  //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	  if (file_exists(Config_L::obtenerPorParametro("empresa_logo")->getValor()))
	  $this->Image(Config_L::obtenerPorParametro("empresa_logo")->getValor(), 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	  else
	  $this->Image('img/logo_pdf_square.png', 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	  // Set font
	  $this->SetFont('helvetica', 'B', 15);
	  // Title
	  $this->Cell(0, 15, _('Reportes ACSM'), 0, false, 'C', 0, '', 0, false, 'M', 'M');

	  } */

	/*
	  function Header()
	  {
	  $this->Cell(180,3,"Respublica Bolivariana de Venzuela",0,1,'C');
	  $this->Cell(180,4,"Universidad Rómulo Gallegos",0,1,'C');
	  $this->Cell(180,5,"San Juan de los Morros Ed. Guárico",0,1,'C');
	  }
	 */

	public function Footer() {

		$this->SetDrawColor(0, 0, 0);
		$this->Line(15, 282, 195, 282);

		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		$this->Cell(0, 10, 'TekBox - www.tekbox.com.ar', 0, 0, 'C');
		// Arial italic 8
		$this->SetFont('helvetica', 'N', 6);
		// Número de página
		$this->Cell(0, 10, _('Página') . ' ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'R');
	}

}

function GenerarReporte($T_Tipo=0, $T_Intervalo=0, $T_Save=0, $T_Filename='', $T_Persona=0, $T_Zona=0, $T_Equipo='', $T_Dispositivo=0, $T_Grupo=0, $T_Imprimir=0, $dias='', $meses='', $a_Logs_Accion='') {
/*	global $dias;
	global $dias_red;
	global $meses;
	global $a_Logs_Accion;
	
*/	

	
	
	$dias = array(_("Domingo"), _("Lunes"), _("Martes"), _("Miércoles"), _("Jueves"), _("Viernes"), _("Sábado"));
	$dias_red = array(_("Dom."), _("Lun."), _("Mar."), _("Mié."), _("Jue."), _("Vie."), _("Sáb."));
	$meses = array(_("Enero"), _("Febrero"), _("Marzo"), _("Abril"), _("Mayo"), _("Junio"), _("Julio"), _("Agosto"), _("Septiembre"), _("Octubre"), _("Noviembre"), _("Diciembre"));
	$a_Logs_Accion = array(
	    _("NULL"),
	    _("INGRESO CORRECTO"), //1
	    _("PERSONA NO REGISTRADA"), //2
	    _("APERTURA PUERTA SMS"),
	    _("PULSADOR"), //4
	    _("ALARMA 1"), //5
	    _("ALARMA 2"), //6
	    _("ALARMA 3"), //7
	    _("TAMPER"), //8
	    _("CORTE DE ENERGIA"),
	    _("CONFIGURACION POR CONSOLA"),
	    _("USER ADDED"),
	    _("USER ENABLED"),
	    _("USER DISABLED"),
	    _("USER EDITED"),
	    _("SIN PERMISOS SUFICIENTES"), //15
	    _("GRABACIÓN ACTIVADA"),
	    _("GRABACIÓN DESACTIVADA"),
	    _("HORA SINCRONIZADA"), //18
	    _("HORA CAMBIADA"),
	    _("FECHA CAMBIADA"),
	    _("FECHA Y HORA CAMBIADAS"),
	    _("PASSWORD SET"), //22
	    _("PASSWORD ENABLED"),
	    _("PASSWORD DISABLED"),
	    _("ALARMA EDITADA"),
	    _("PERSONA DESACTIVADA"), //26
	    _("NRO SERVER CHANGED"),
	    _("MASTER TAG CHANGED"),
	    _("HOSTNAME CAMBIADO"), //29
	    _("HOSTNAME RESETEADO"),
	    _("IP ACSM CAMBIADA"),
	    _("IP ACSM RESETEADA"),
	    _("GRABACIÓN ACTIVADA POR CONSOLA"),
	    _("GRABACIÓN DESACTIVADA POR CONSOLA"),
	    _("SE CAMBIÓ LA IP"), //35
	    _("SE CAMBIÓ EL DNS"), //36
	    _("SE CAMBIÓ EL DEFAULT GATEWAY"),
	    _("SE DESACTIVO DHCP"), //38
	    _("SE ACTIVO DHCP"), //39
	    _("FUERA DE HORARIO"), //40
	    _("SE RESETEÓ LA CONFIGURACION DESDE EL ACSM"),
	    _("SE RESETEÓ LA CONFIGURACION DESDE LA CONSOLA"), //42
	    _("SE BORRARON TODOS LOS USUARIOS DESDE EL SERVER"),
	    _("SE BORRARON TODOS LOS USUARIOS DESDE LA CONSOLA"), //44
	    _("SYNC USUARIOS AGREGADOS"),
	    _("SYNC USUARIOS ACTUALIZADOS"),
	    _("SYNC LECTORES ACTUALIZADOS"),
	    _("SYNC TEMPORIZADORES ACTUALIZADOS"),
	    _("SYNC ALARMAS EDITADAS"),
	    _("SYNC PULSADORES ACTUALIZADOS"), //50
	    _("GATEWAY ACTIVADO"),
	    _("GATEWAY DESACTIVADO"),
	    _("SE PERDIÓ LA CONEXIÓN CON EL ACSM"), //53
	    _("REINICIO GATEWAY"), //54
	    _("HORA SINCRONIZADA POR DESFASAJE"), //55
	    _("ERROR DE LECTURA")    //56
	);

	// Creación del objeto de la clase heredada
	$pdf = new PDF('P', 'mm', 'A4');

	$pdf->setDias($dias);
	$pdf->setMeses($meses);

	//inicializo las fuentes
	$pdf->AddFont('Times', '', 'times.ttf', true);
	$pdf->AddFont('Times', 'B', 'timesbd.ttf', true);
	$pdf->AddFont('Times', 'BI', 'timesbi.ttf', true);
	$pdf->AddFont('Times', 'I', 'timesi.ttf', true);
	$pdf->AddFont('Arial', '', 'arial.ttf', true);
	$pdf->AddFont('Arial', 'B', 'arialbd.ttf', true);
	$pdf->AddFont('Arial', 'BI', 'arialbi.ttf', true);
	$pdf->AddFont('Arial', 'I', 'ariali.ttf', true);

	if ($T_Intervalo == 0 && $T_Tipo != 18 && $T_Tipo != 19 && $T_Tipo != 20 && $T_Tipo != 21 && $T_Tipo != 22 && $T_Tipo != 23 && $T_Tipo != 40)
		die(_("Intervalo incorrecto"));
		
	
	if(isset($T_Intervalo)){
		switch($T_Intervalo){
			case 1://diario
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('today 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('tomorrow 00:00'));
			break;
			case 7://semana
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('this week 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('next week 00:00'));
			break;
			case 15://quincena
				$primerDiadelMes=strtotime('first day of this month 00:00');
				$ultimoDiadelMes=strtotime('first day of next month 00:00');
				$mitadDelMes=strtotime('+15 days',$primerDiadelMes);
				if(time()<$mitadDelMes){//primera quincena					
					$_SESSION['filtro']['fechaD']= date('Y-m-d H:i:s',$primerDiadelMes);
					$_SESSION['filtro']['fechaH']= date('Y-m-d H:i:s',$mitadDelMes);
				}
				else {					
					$_SESSION['filtro']['fechaD']= date('Y-m-d H:i:s',$mitadDelMes);
					$_SESSION['filtro']['fechaH']= date('Y-m-d H:i:s',$ultimoDiadelMes);
				}				
			break;
			case 30://mes
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime('first day of this month 00:00'));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime('first day of next month 00:00'));
			break;
			case 365://mes
				$_SESSION['filtro']['fechaD']=date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 "));
				$_SESSION['filtro']['fechaH']=date('Y-m-d H:i:s',strtotime("first day of january " . date('Y') . " 00:00 +1 year"));
			break;
		}
	}

	/*
	 * tipo 10 = reporte por persona
	 * tipo 11 = reporte por zona
	 * tipo 12 = reporte de equipo
	 * tipo 13 = reporte de alarmas
	 * tipo 14 = reporte por perifericos
	 * tipo 15 = reporte de persona y periferico
	 * tipo 16 = reporte general
	 * tipo 17 = reporte por grupo
	 * tipo 18 = listado de personas
	 *
	 * */

	if ($T_Tipo == 18) {//LISTADO DE PERSONAS
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes ACSM');
		$titulo_2 = _('Listado de Personas');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));		
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

		if (file_exists(Config_L::obtenerPorParametro("empresa_logo")->getValor()))
			$image = Config_L::obtenerPorParametro("empresa_logo")->getValor();
		else
			$image = 'img/logo_pdf_square.png';
		$titulo = $titulo_1;
		$header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

		$pdf->setHeaderFont(array("freesans", "", 9));
		$pdf->SetHeaderData('../../../' . $image
			, 30
			, $titulo
			, $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		$a_pdf = array();
		$T_Total_Registros = PaginadoHelper::getCount('persona');
		$o_Listado = Persona_L::obtenerTodos(1, $T_Total_Registros, $T_Total_Registros);

		if ($o_Listado != array()) {

			$html = '';

			foreach ($o_Listado as $indice => $t_persona) {

				$a_pdf[$indice]['legajo'] = (($t_persona->getLegajo() != "") ? $t_persona->getLegajo() : "");
				$a_pdf[$indice]['nombre'] = $t_persona->getNombreCompletoINV();
				$a_pdf[$indice]['dni'] = (($t_persona->getDni() != "") ? $t_persona->getDni() : "");
				$oTarjeta = Tarjeta_L::obtenerPorTag($t_persona->getTag());
				if ($oTarjeta != null) {
					$a_pdf[$indice]['cod_tarjeta'] = $oTarjeta->getCodigo();
				} else {
					$a_pdf[$indice]['cod_tarjeta'] = 'N/A';
				}
				$a_pdf[$indice]['te'] = (($t_persona->getTePersonal() != "") ? 'T. ' . $t_persona->getTePersonal() : "");
				$a_pdf[$indice]['cel'] = (($t_persona->getTeCelular() != "") ? 'C. ' . $t_persona->getTeCelular() : "");
				$a_pdf[$indice]['email'] = (($t_persona->getEmail() != "") ? $t_persona->getEmail() : "");

				$a_pdf[$indice]['permiso'] = (($t_persona->getPermisoObject()->getDetalle() != "") ? $t_persona->getPermisoObject()->getDetalle() : "");

				$a_pdf[$indice]['hora_tabajo'] = (($t_persona->getHoraTrabajoObject()->getDetalle() != "") ? $t_persona->getHoraTrabajoObject()->getDetalle() : "");

				$a_pdf[$indice]['bloqueado'] = (($t_persona->getEliminadoEl(Config_L::p('f_fecha_corta')) != "") ? $t_persona->getEliminadoEl(Config_L::p('f_fecha_corta')) : "");
			}
		}

		//echo'<pre>';print_r($a_pdf);echo'</pre>';
		if ($a_pdf != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			$html .= '<table border="1" cellspacing="0" cellpadding="3">';
			$html .= '<tr>';
			$html .= '<th width="27%" align="left" bgcolor="#3C3C3C"><font color="#FFF">' . _('Legajo') . "<br />" . _('Persona') . "<br />" . _('DNI - Código Tarjeta') . '</font></th>';
			$html .= '<th width="21%" align="left" bgcolor="#3C3C3C"><font color="#FFF">' . _('Teléfono') . "<br />" . _('Celular') . '</font></th>';
			$html .= '<th width="20%" align="left" bgcolor="#3C3C3C"><font color="#FFF">' . _('E-mail') . '</font></th>';
			$html .= '<th width="20%" align="left" bgcolor="#3C3C3C"><font color="#FFF">' . _('Permiso/Hora de Tababajo') . '</font></th>';
			$html .= '<th width="12%" align="left" bgcolor="#3C3C3C"><font color="#FFF">' . _('Bloq.') . '</font></th>';
			$html .= '</tr>';

			foreach ($a_pdf as $t_renglon) {
				$html .= '<tr>';
				$html .= '<td><font color="#F00">' . $t_renglon['legajo'] . "</font><br />" . $t_renglon['nombre'] . "<br />" . $t_renglon['dni'] . " - " . $t_renglon['cod_tarjeta'] . '</td>';
				$html .= '<td>' . $t_renglon['te'] . ' <br /> ' . $t_renglon['cel'] . '</td>';
				$html .= '<td>' . $t_renglon['email'] . '</td>';
				$html .= '<td>' . $t_renglon['hora_tabajo'] . '</td>';
				$html .= '<td>' . $t_renglon['bloqueado'] . '</td>';
				$html .= '</tr>';
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}

		$pdf->lastPage();
	} elseif ($T_Tipo == 19) {// LLegadas Tarde ************************************************************************************************************************
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes enPunto');
		$titulo_2 = _('Llegadas Tarde');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

		if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
			$image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
		else
			$image = 'img/logo_pdf_square.png';
		$titulo = $titulo_1;
		$header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

		$pdf->setHeaderFont(array("freesans", "", 9));
		$pdf->SetHeaderData($image
			, 30
			, $titulo
			, $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		include_once 'codigo/includes/reporte_control_personal.php';

		if ($a_pdf != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			foreach ($a_pdf as $t_renglon) {
				if (isset($t_renglon['legajo'])) {
					if ($recordar_leg != '') {
						$html .='</table>';
						$html .='<br /><br />';
					}
					$html .= '<table border="1" cellspacing="0" cellpadding="3">';
					$recordar_leg = $t_renglon['legajo'];
					$html .= '<tr>';

					$html .= '<th colspan="5" align="left" bgcolor="#3C3C3C">'
						. '<table border="0" cellspacing="0" cellpadding="3">'
						. '<tr>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . '</font></td>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></td>'
						. '</tr>'
						. '</table>'
						. '</th>';

					//$html .= '<th width="20%" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['legajo'] . '</font></th>';
					//$html .= '<th width="40%" colspan="2" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['nombre'] . '</font></th>';
					//$html .= '<th width="40%" colspan="2" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></th>';
					//$html .= '<th colspan="3" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . ' - ' . $t_renglon['horarios'] . '</font></th>';

					$html .= '</tr>';
					$html .= '<tr>';
					$html .= '<th width="20%" bgcolor="#CCCCCC"> ' . $t_renglon['t1'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t2'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t3'] . '</th>';
					$html .= '</tr>';
				}
				$html .= '<tr>';
				$html .= '<td> ' . $t_renglon['fecha'] . '</td>';
				$t_color = ($t_renglon['ing_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['ingreso'] . '</td>';
				$t_color = ($t_renglon['sal_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['salida'] . '</td>';
				$html .= '</tr>';
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}


		$pdf->lastPage();
	} elseif ($T_Tipo == 23) {// Salidas Temprano ************************************************************************************************************************
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes enPunto');
		$titulo_2 = _('Salidas Temprano');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

        if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
            $image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
        else
            $image = 'img/logo_pdf_square.png';
        $titulo = $titulo_1;
        $header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

        $pdf->setHeaderFont(array("freesans", "", 9));
        $pdf->SetHeaderData($image
            , 30
            , $titulo
            , $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		include_once 'codigo/includes/reporte_control_personal.php';

		if ($a_pdf != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			foreach ($a_pdf as $t_renglon) {
				if (isset($t_renglon['legajo'])) {
					if ($recordar_leg != '') {
						$html .='</table>';
						$html .='<br /><br />';
					}
					$html .= '<table border="1" cellspacing="0" cellpadding="3">';
					$recordar_leg = $t_renglon['legajo'];
					$html .= '<tr>';

					$html .= '<th colspan="5" align="left" bgcolor="#3C3C3C">'
						. '<table border="0" cellspacing="0" cellpadding="3">'
						. '<tr>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . '</font></td>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></td>'
						. '</tr>'
						. '</table>'
						. '</th>';

					//$html .= '<th width="20%" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['legajo'] . '</font></th>';
					//$html .= '<th width="40%" colspan="2" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['nombre'] . '</font></th>';
					//$html .= '<th width="40%" colspan="2" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></th>';
					//$html .= '<th colspan="3" align="left" bgcolor="#3C3C3C"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . ' - ' . $t_renglon['horarios'] . '</font></th>';

					$html .= '</tr>';
					$html .= '<tr>';
					$html .= '<th width="20%" bgcolor="#CCCCCC"> ' . $t_renglon['t1'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t2'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t3'] . '</th>';
					$html .= '</tr>';
				}
				$html .= '<tr>';
				$html .= '<td> ' . $t_renglon['fecha'] . '</td>';
				$t_color = ($t_renglon['ing_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['ingreso'] . '</td>';
				$t_color = ($t_renglon['sal_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['salida'] . '</td>';
				$html .= '</tr>';
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}


		$pdf->lastPage();
	} elseif ($T_Tipo == 20) {// Entradas/Salidas*********************************************************************************************************************
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes enPunto');
		$titulo_2 = _('Entradas/Salidas');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

        if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
            $image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
        else
            $image = 'img/logo_pdf_square.png';
        $titulo = $titulo_1;
        $header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

        $pdf->setHeaderFont(array("freesans", "", 9));
        $pdf->SetHeaderData($image
            , 30
            , $titulo
            , $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		include_once 'codigo/includes/reporte_control_personal.php';

		if ($a_pdf != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			foreach ($a_pdf as $t_renglon) {
				if (isset($t_renglon['legajo'])) {
					if ($recordar_leg != '') {
						$html .='</table>';
						$html .='<br /><br />';
					}
					$html .= '<table border="1" cellspacing="0" cellpadding="3">';
					$recordar_leg = $t_renglon['legajo'];
					$html .= '<tr>';
					$html .= '<th colspan="5" align="left" bgcolor="#3C3C3C">'
						. '<table border="0"  cellspacing="0" cellpadding="3">'
						. '<tr>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . '</font></td>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></td>'
						. '</tr>'
						. '</table>'
						. '</th>';
					$html .= '</tr>';
					$html .= '<tr>';
					$html .= '<th width="20%" bgcolor="#CCCCCC"> ' . $t_renglon['t1'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t2'] . '</th>';
					$html .= '<th width="40%" bgcolor="#CCCCCC"> ' . $t_renglon['t3'] . '</th>';
					$html .= '</tr>';
				}
				$html .= '<tr>';
				$html .= '<td> ' . $t_renglon['fecha'] . '</td>';
				$t_color = ($t_renglon['ing_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['ingreso'] . '</td>';
				$t_color = ($t_renglon['sal_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
				$html .= '<td' . $t_color . '>' . $t_renglon['salida'] . '</td>';
				$html .= '</tr>';
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}

		$pdf->lastPage();
	} elseif ($T_Tipo == 21) {// Dias/Horas Trabajadas************************************************************************************************************************
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes enPunto');
		$titulo_2 = _('Días/Horas Trabajadas');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

        if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
            $image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
        else
            $image = 'img/logo_pdf_square.png';
        $titulo = $titulo_1;
        $header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

        $pdf->setHeaderFont(array("freesans", "", 9));
        $pdf->SetHeaderData($image
            , 30
            , $titulo
            , $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		include_once 'codigo/includes/reporte_control_personal.php';

		if ($a_pdf != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			foreach ($a_pdf as $t_renglon) {
				if (isset($t_renglon['legajo'])) {
					if ($recordar_leg != '') {
						if (isset($t_renglon['inconsistencia']) && $t_renglon['inconsistencia'] != '') {
							$html .= '<tr>';
							$html .= '<td colspan="5" bgcolor="#FBE3E4"><font color="#FE0026">' . $t_renglon['inconsistencia'] . '</font></td>';
							$html .= '</tr>';
						}

						if (isset($t_renglon['t10'])) {
							$html .= '<tr>';
							$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['t10'] . '</td>';
							$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['dias_acumula'] . '</td>';
							$html .= '<td bgcolor="#CCCCCC"> </td>';
							$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['t11'] . '</td>';
							$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['horas_acumula'] . '</td>';
							$html .= '</tr>';
						}
						$html .='</table>';
						$html .='<br /><br />';
					}
					$html .= '<table border="1" cellspacing="0" cellpadding="3">';
					$recordar_leg = $t_renglon['legajo'];
					$html .= '<tr>';
					$html .= '<th colspan="5" align="left" bgcolor="#3C3C3C">'
						. '<table border="0"  cellspacing="0" cellpadding="3">'
						. '<tr>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['legajo'] . ' - ' . $t_renglon['nombre'] . '</font></td>'
						. '<td width="50%"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></td>'
						. '</tr>'
						. '</table>'
						. '</th>';
					$html .= '</tr>';
					$html .= '<tr>';
					$html .= '<th width="20%" bgcolor="#CCCCCC"> ' . $t_renglon['t1'] . '</th>';
					$html .= '<th width="22%" bgcolor="#CCCCCC"> ' . $t_renglon['t2'] . '</th>';
					$html .= '<th width="22%" bgcolor="#CCCCCC"> ' . $t_renglon['t3'] . '</th>';
					$html .= '<th width="18%" bgcolor="#CCCCCC"> ' . $t_renglon['t4'] . '</th>';
					$html .= '<th width="18%" bgcolor="#CCCCCC"> ' . $t_renglon['t5'] . '</th>';
					$html .= '</tr>';
				}
				if (isset($t_renglon['fecha'])) {
					$html .= '<tr>';
					$html .= '<td> ' . $t_renglon['fecha'] . '</td>';
					$t_color = ($t_renglon['ing_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
					$html .= '<td' . $t_color . '>' . $t_renglon['ingreso'] . '</td>';
					$t_color = ($t_renglon['sal_tarde'] == 'Si') ? ' bgcolor="#FF9999"' : '';
					$html .= '<td' . $t_color . '>' . $t_renglon['salida'] . '</td>';
					$html .= '<td>' . $t_renglon['total_horas'] . '</td>';
					$html .= '<td>' . $t_renglon['acumula_x_dia'] . '</td>';
					$html .= '</tr>';
				}
			}
			if (isset($t_renglon['inconsistencia']) && $t_renglon['inconsistencia'] != '') {
				$html .= '<tr>';
				$html .= '<td colspan="5" bgcolor="#FBE3E4"><font color="#FE0026">' . $t_renglon['inconsistencia'] . '</font></td>';
				$html .= '</tr>';
			}

			if (isset($t_renglon['t10'])) {
				$html .= '<tr>';
				$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['t10'] . '</td>';
				$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['dias_acumula'] . '</td>';
				$html .= '<td bgcolor="#CCCCCC"> </td>';
				$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['t11'] . '</td>';
				$html .= '<td bgcolor="#CCCCCC"> ' . $t_renglon['horas_acumula'] . '</td>';
				$html .= '</tr>';
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}

		$pdf->lastPage();
	} elseif ($T_Tipo == 22) {// Ausencias********************************************************************************************************************
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes enPunto');
		$titulo_2 = _('Ausencias');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

        if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
            $image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
        else
            $image = 'img/logo_pdf_square.png';
        $titulo = $titulo_1;
        $header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

        $pdf->setHeaderFont(array("freesans", "", 9));
        $pdf->SetHeaderData($image
            , 30
            , $titulo
            , $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();

		include_once 'codigo/includes/reporte_control_personal.php';

		if (isset($a_aus) && $a_aus != array()) {
			$t_color = '';
			$recordar_leg = '';
			$html = '';

			foreach ($a_aus as $t_Legajo => $t_renglon) {
				if (isset($t_Legajo)) {
					if ($recordar_leg != '') {
						$html .='</table>';
						$html .='<br /><br />';
					}
					$html .= '<table border="1" cellspacing="0" cellpadding="3">';
					$recordar_leg = $t_Legajo;
					$html .= '<tr>';

					$html .= '<th colspan="5" align="left" bgcolor="#3C3C3C">'
						. '<table border="0" cellspacing="0" cellpadding="3">'
						. '<tr>'
						. '<td width="100%"> <font color="#FFF">' . $t_renglon['leg_ape_nomb'] . '</font></td>'
						//. '<td width="60%"> <font color="#FFF">' . $t_renglon['horarios'] . '</font></td>'
						. '</tr>'
						. '</table>'
						. '</th>';

					$html .= '</tr>';
					$html .= '<tr>';
					$html .= '<th width="100%" bgcolor="#CCCCCC"> ' . _('Fecha de la Ausencia') . '</th>';
					$html .= '</tr>';
				}

				foreach ($t_renglon['fecha'] as $t_fecha) {
					$html .= '<tr>';
					$html .= '<td> ' . htmlentities($dias[date('w', strtotime($t_fecha))] . ' '. date(Config_L::p('f_fecha'), strtotime($t_fecha)), ENT_QUOTES, 'utf-8') . '</td>';
					
					$html .= '</tr>';
				}
			}
			$html .='</table>';
			//$html .='<br /><br />';
			// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}


		$pdf->lastPage();
	} else if ($T_Tipo == 30) {//REPORTE DE VIOLACIONES DE ACCESO
		if ($T_Persona == 0)
			die(_("Falta la PERSONA"));

		if (Persona_L::obtenerPorId($T_Persona) == null)
			die(_("La Persona no existe."));

		$titulo_1 = _('Reporte de Persona');

		$pdf->setTitulo($titulo_1);

		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times', '', 12);
		$pdf->SetTitle(_("Reportes ACSM"));
		$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		$pdf->SetKeywords($titulo_1);

		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell(0, 0, Persona_L::obtenerPorId($T_Persona)->getLegajo() . ' - ' . Persona_L::obtenerPorId($T_Persona)->getNombreCompleto(), 0, 0, 'L');
		$pdf->Ln(5);

		$data = '';
		$header = array(_('Fecha y Hora'), _('Periférico'), _('Detalle'));

		$condicion = "lga_Per_Id = " . $T_Persona . " AND lga_Fecha_Hora >= '{$_SESSION['filtro']['fechaD']}' AND lga_Fecha_Hora <= '{$_SESSION['filtro']['fechaH']}' AND (lga_Accion=15 OR lga_Accion=26 OR lga_Accion=40 )  ";
		$T_Total_Registros = PaginadoHelper::getCount('logs_equipo', $condicion);
		$o_Listado = Logs_Equipo_L::obtenerTodosO(1, $T_Total_Registros, $T_Total_Registros, $condicion, "DESC", "lga_Fecha_Hora");
		if ($o_Listado != null) {
			foreach ($o_Listado as $t_persona) {
				$dispositivo = array();
				$o_Dispo = Dispositivo_L::obtenerPorLector($t_persona->getLector(), $t_persona->getEqId());
				if (!is_null($o_Dispo)) {
					foreach ($o_Dispo as $v_dis) {
						$dispositivo[] = $v_dis->getNombre();
					}
				}
				$dispositivo = implode(' - ', $dispositivo);
				if (strlen($dispositivo) > 65)
					$dispositivo = substr($dispositivo, 0, 65) . '...';

				$data[] = array($t_persona->getFechaHora(Config_L::p('f_fecha_corta')), $dispositivo, $a_Logs_Accion[$t_persona->getAccion()]);
			}
			$pdf->Tabla($header, $data, array(35, 105, 50));
		}
		else {
			$pdf->Cell(140, 10, _('No hay registros disponibles.'), 0, 0, 'L');
		}
	} elseif ($T_Tipo == 40) {// Esquema de Conexiones
		$pdf = new MiPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$titulo_1 = _('Reportes ACSM');
		$titulo_2 = _('Esquema de Conexiones');
		$dia_actual = _('Generado el ') . $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		$periodo = _('Reporte desde el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaD'])) . _(' hasta el ') . date(Config_L::p('f_fecha_corta'), strtotime($_SESSION['filtro']['fechaH']));

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		if(Registry::getInstance()->Usuario!=null)
			$pdf->SetAuthor(Registry::getInstance()->Usuario->getApellido() . ', ' . Registry::getInstance()->Usuario->getNombre());
		else 
			$pdf->SetAuthor(_("Reporte generado automáticamente por el sistema de notificaciones"));
		$pdf->SetTitle($titulo_2);
		$pdf->SetSubject($periodo);
		$pdf->SetKeywords($titulo_1);

// set default header data

        if (file_exists(GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo")))
            $image = GS_CLIENT_IMAGES_LOGO.Config_L::p("empresa_logo");
        else
            $image = 'img/logo_pdf_square.png';
        $titulo = $titulo_1;
        $header = $titulo_2 . "\n" . $dia_actual . "\n" . $periodo;

        $pdf->setHeaderFont(array("freesans", "", 9));
        $pdf->SetHeaderData($image
            , 30
            , $titulo
            , $header);

// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

// ---------------------------------------------------------
// set font
		$pdf->SetFont('dejavusans', '', 10);

		$pdf->AddPage();
		$ban_pasa_1 = 0;
		$html = '';
		$a_Salida = array(1 => 'S-01', 'S-02', 'S-03', 'S-04', 'S-05', 'S-06', 'S-07', 'S-08');
		$a_Lector = array(1 => 'L-01', 'L-02', 'L-03', 'L-04', 'L-05', 'L-06', 'L-07', 'L-08');
		$a_Pulsador = array(1 => 'P-01', 'P-02', 'P-03', 'P-04', 'P-05', 'P-06', 'P-07', 'P-08');
		$o_Listado = Dispositivo_L::obtenerTodos();

		if (!empty($o_Listado)) {
			foreach ($o_Listado as $key => $item) {
				if ($ban_pasa_1 != $item->getEqId() && $ban_pasa_1 != 0) {
					$html .='		</table><br /><br />';
				}
				if ($ban_pasa_1 != $item->getEqId()) {
					$html .='
					<table width="100%" border="0" cellspacing="2" cellpadding="3">
							<tr bgcolor="#5A2627">
							<td><h2><font color="#fff">' . htmlentities($item->getEquipoObject()->getDetalle(), ENT_COMPAT, 'utf-8') . ' </font></h2></td>
							</tr>
						</table>
						<h3>' . _('Datos del Equipo') . '</h3>
						
						<table width="100%" border="1" cellspacing="0" cellpadding="3">
							<tr bgcolor="#000">
								<th><font color="#FFF">' . _('Hostname') . '</font></th>
								<th><font color="#FFF">' . _('Ip') . '</font></th>
								<th><font color="#FFF">' . _('Contraseña') . '</font></th>

							</tr>
							<tr>
								<td>
									' . htmlentities($item->getEquipoObject()->getHost(), ENT_COMPAT, 'utf-8') . '
								</td>
								<td>
									' . htmlentities($item->getEquipoObject()->getIp(), ENT_COMPAT, 'utf-8') . '
								</td>
								<td>
									' . htmlentities($item->getEquipoObject()->getPassword(), ENT_COMPAT, 'utf-8') . '
								</td>
							</tr>
						</table>
						<h3>' . _('Datos de cableado del Equipo') . '</h3>
						<br />
						<table  width="100%" border="1" cellspacing="0" cellpadding="3">
							<tr bgcolor="#000">
								<th><font color="#FFF">' . _('Ubicación') . '</font></th>
								<th><font color="#FFF">' . _('Switch') . '</font></th>
								<th><font color="#FFF">' . _('Puerto') . '</font></th>
							</tr>
							<tr>
								<td>
									' . htmlentities($item->getEquipoObject()->getUbicacion(), ENT_COMPAT, 'utf-8') . '
								</td>
								<td>
									' . htmlentities($item->getEquipoObject()->getSwitch(), ENT_COMPAT, 'utf-8') . '
								</td>
								<td>
									' . htmlentities($item->getEquipoObject()->getPuerto(), ENT_COMPAT, 'utf-8') . '
								</td>
							</tr>
						</table>
						<h3>' . _('Datos de Periféricos') . '</h3>
						<br />
						<table width="100%" border="1" cellspacing="0" cellpadding="3">';
				}
				$html .='		
						<tr bgcolor="#000">
							<th  colspan="5"  color="#FFF">' . htmlentities($item->getNombre(), ENT_COMPAT, 'utf-8') . '</th>
						</tr>';
				$html .='<tr bgcolor="#CCCCCC">
							<th colspan="2">' . _('Tipo de Periférico') . '</th>
							<th colspan="3">' . _('Timer') . '</th>
						</tr>';
				$html .='	<tr>';
				$html .='		
							<td colspan="2">' . (($item->getTdiId() != 0) ? htmlentities($item->getDispositivoTipoObject()->getDetalle(), ENT_COMPAT, 'utf-8') : '----') . '</td>
							<td colspan="3">' . htmlentities($item->getTemporizador(), ENT_COMPAT, 'utf-8') . '</td>	
						</tr>';
				if ($item->getSalida() != 0) {
					$html .='			<tr bgcolor="#CCCCCC">
										<th>' . _('Salida') . ' - ' . _('Etiqueta') . '</th>
										<th>' . _('N') . '</th>
										<th>' . _('NA') . '</th>
										<th>' . _('NC') . '</th>
										<th>&nbsp;</th>

									</tr>';
					$html .='	<tr>';
					$html .='			<td>' . (($item->getSalida() != 0) ? htmlentities($a_Salida[$item->getSalida()], ENT_COMPAT, 'utf-8') : '----') . ' - ' . (($item->getSalidaEtiqueta() != '') ? htmlentities($item->getSalidaEtiqueta(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getSalida1() != '') ? htmlentities($item->getSalida1(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getSalida2() != '') ? htmlentities($item->getSalida2(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getSalida3() != '') ? htmlentities($item->getSalida3(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>&nbsp;</td>
									</tr>';
				}
				if ($item->getLector() != 0) {
					$html .='		<tr bgcolor="#CCCCCC">
										<th>' . _('Lector') . ' - ' . _('Etiqueta') . '</th>
										<th>' . _('VCC') . '</th>
										<th>' . _('GND') . ':</th>
										<th>' . _('D0') . ':</th>
										<th>' . _('D1') . ':</th>
									</tr>';
					$html .='	<tr>';
					$html .='			<td>' . (($item->getLector() != 0) ? htmlentities($a_Lector[$item->getLector()], ENT_COMPAT, 'utf-8') : '----') . ' - ' . (($item->getLectorEtiqueta() != '') ? htmlentities($item->getLectorEtiqueta(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getLector1() != '') ? htmlentities($item->getLector1(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getLector2() != '') ? htmlentities($item->getLector2(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getLector3() != '') ? htmlentities($item->getLector3(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getLector4() != '') ? htmlentities($item->getLector4(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
									</tr>';
				}
				if ($item->getPulsador() != 0) {
					$html .='			<tr bgcolor="#CCCCCC">
										<th>' . _('Pulsador') . ' - ' . _('Etiqueta') . '</th>
										<th>' . _('C1') . '</th>
										<th>' . _('C2') . '</th>
										<th>&nbsp;</th>
										<th>&nbsp;</th>
									</tr>';
					$html .='	<tr>';
					$html .='			<td>' . (($item->getPulsador() != 0) ? htmlentities($a_Pulsador[$item->getPulsador()], ENT_COMPAT, 'utf-8') : '----') . ' - ' . (($item->getPulsadorEtiqueta() != '') ? htmlentities($item->getPulsadorEtiqueta(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getPulsador1() != '') ? htmlentities($item->getPulsador1(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>' . (($item->getPulsador2() != '') ? htmlentities($item->getPulsador2(), ENT_COMPAT, 'utf-8') : '&nbsp;') . '</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>';
				}
				$html .='			<tr class="tb_blanco"><td colspan="5"> &nbsp; </td></tr>';
				$ban_pasa_1 = $item->getEqId();
			}
			$html .='</table>';
			//$html .='<br />';
			// output the HTML content
			//echo $html;
			$pdf->writeHTML($html, true, false, true, false, '');
		} else {

			$html = '<span color="red">' . _('No hay registros disponibles.') . '</span>';

			$pdf->SetFillColor(255, 255, 0);

			$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
		}

		$pdf->lastPage();
	}

	//FALTA GENERAR LOGS ALARMAS PARA PROBARLOS
	else {
		die(_("Falta el TIPO"));
	}


	//falta el pie de pagina



	if ($T_Imprimir == 1)
		$pdf->IncludeJS("print('true');");


	if ($T_Save == 1) {//save in FS
		$path=GS_CLIENT_TEMP_FOLDER;

		if (!file_exists($path))
			mkdir($path, 0777, true);

		$pdf->Output($path . $T_Filename, "F");
	}
	else if ($T_Save == 2) {//download
		$pdf->Output($T_Filename, "D");
	}
	else {//open in browser
		$pdf->Output();
	}
}

function Get_Intervalo($desde, $hasta) {


	if ($desde == 0 || $desde == null || $desde == '')
		$desde = time() - 60 * 60 * 24 * 34;  //si no hay fecha desde, lo limito a 30 dias.
	else
		$desde = (strtotime($desde));

	if ($hasta == 0 || $hasta == null || $hasta == '')
		$hasta = time();
	else
		$hasta = (strtotime($hasta));

	$offset = $hasta - $desde;

	$offset = floor($offset / 60 / 60 / 24);
	if ($offset == 0)
		return 1;
	else
		return $offset;

	//return floor($offset / 60 / 60 / 24);
}

