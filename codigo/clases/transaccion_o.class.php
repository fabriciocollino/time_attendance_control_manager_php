<?php


class Transaccion_O
{

    private $_id;
    private $_fecha;
    private $_vencimiento;
    private $_fecha_pago;
    private $_cliente;
    private $_suscripcion;
    private $_plan;
    private $_monto;
    private $_monto_sin_iva;
    private $_metodo;
    private $_periodo;
    private $_estado;
    private $_payu_responce;

    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_fecha = '';
        $this->_vencimiento = '';
        $this->_fecha_pago = '';
        $this->_cliente = 0;
        $this->_suscripcion = 0;
        $this->_plan = 0;
        $this->_monto = '';
        $this->_monto_sin_iva = '';
        $this->_metodo = '';
        $this->_periodo = '';
        $this->_estado = 0;
        $this->_payu_responce = '';

    }

    public function getId() {
        return $this->_id;
    }

    public function setId($p_id) {
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }

    public function getFecha($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_fecha)) {
                return '';
            } else {
                $fecha = DateTimeHelper::getTimestampFromFormat($this->_fecha, "Y-m-d H:i:s");
                return date($pFormat, $fecha);
            }
        }
        return $this->_fecha;
    }

    public function setFecha($pFecha) {
        $this->_fecha=$pFecha;
    }

    public function getVencimiento($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_vencimiento)) {
                return '';
            } else {
                $fecha = DateTimeHelper::getTimestampFromFormat($this->_vencimiento, "Y-m-d H:i:s");
                return date($pFormat, $fecha);
            }
        }
        return $this->_vencimiento;
    }

    public function setVencimiento($pFecha) {
        $this->_vencimiento=$pFecha;
    }

    public function getFechaPago($pFormat = null) {
        if (!is_null($pFormat) && is_string($pFormat)) {
            if (is_null($this->_fecha_pago)) {
                return '';
            } else {
                $fecha = DateTimeHelper::getTimestampFromFormat($this->_fecha_pago, "Y-m-d H:i:s");
                return date($pFormat, $fecha);
            }
        }
        return $this->_fecha_pago;
    }

    public function setFechaPago($pFecha) {
        $this->_fecha_pago=$pFecha;
    }

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente($p_cliente) {
        $p_cliente = (integer)$p_cliente;
        $this->_cliente = $p_cliente;
    }
    

    public function getSuscripcion() {
        return $this->_suscripcion;
    }

    public function setSuscripcion($p_suscripcion) {
        $p_suscripcion = (integer)$p_suscripcion;
        $this->_suscripcion = $p_suscripcion;
    }

    public function getPlan() {
        return $this->_plan;
    }

    public function setPlan($p_plan) {
        $p_plan = (integer)$p_plan;
        $this->_plan = $p_plan;
    }

    public function getMonto() {
        return $this->_monto;
    }

    public function setMonto($p_monto) {
        $p_monto = (string)$p_monto;
        $this->_monto = $p_monto;
    }

    public function getMontoSinIVA() {
        return $this->_monto_sin_iva;
    }

    public function setMontoSinIVA($p_monto) {
        $p_monto = (string)$p_monto;
        $this->_monto_sin_iva = $p_monto;
    }

    public function getMetodo_S() {
        switch($this->_metodo){
            case 'credito':
                return 'Tarjeta de Crédito';
            break;
            case 'efectivo';
                return 'Pago Fácil/Rapipago';
                break;
            case 'transferencia':
                return 'Transferencia/Cheque';
                break;
        }
    }

    public function setMetodo($p_metodo) {
        $p_metodo = (string)$p_metodo;
        $this->_metodo = $p_metodo;
    }

    public function getPeriodo() {
        return $this->_periodo;
    }

    public function getPeriodo_S() {
        switch ($this->_periodo){
            case 'MONTH':
                return 'Mensual';
                break;
            case 'YEAR':
                return 'Anual';
                break;
        }
    }

    public function setPeriodo($p_periodo) {
        $p_periodo = (string)$p_periodo;
        $this->_periodo = $p_periodo;
    }

    public function getEstado() {
        return $this->_estado;
    }

    public function getEstadoLabel() {
        switch($this->_estado){
            case TRANSACTION_PENDING:
                return 'warning';
            break;
            case TRANSACTION_APPROVED:
                return 'primary';
            break;
            case TRANSACTION_REJECTED:
                return 'danger';
            break;
            case TRANSACTION_PAID:
                return 'success';
            break;
            case TRANSACTION_UNPAID:
                return 'info';
            break;
        }
    }

    public function setEstado($p_estado) {
        $p_estado = (integer)$p_estado;
        $this->_estado = $p_estado;
    }

    public function getPayuResponce() {
        return $this->_payu_responce;
    }

    public function setPayuResponce($p_responce) {
        $p_responce = (string)$p_responce;
        $this->_payu_responce = $p_responce;
    }

    public function loadArray($p_Datos) {
        $this->_id = (integer)$p_Datos["trans_Id"];
        $this->_fecha = (string)$p_Datos["trans_Fecha"];
        $this->_vencimiento = (string)$p_Datos["trans_Vencimiento"];
        $this->_fecha_pago = (string)$p_Datos["trans_Fecha_Pago"];
        $this->_cliente = (integer)$p_Datos["trans_Cliente"];
        $this->_suscripcion = (integer)$p_Datos["trans_Suscripcion"];
        $this->_plan = (integer)$p_Datos["trans_Plan"];
        $this->_monto = (string)$p_Datos["trans_Monto"];
        $this->_monto_sin_iva = (string)$p_Datos["trans_Monto_Sin_IVA"];
        $this->_metodo = (string)$p_Datos["trans_Metodo"];
        $this->_periodo = (string)$p_Datos["trans_Periodo"];
        $this->_estado = (integer)$p_Datos["trans_Estado"];
        $this->_payu_responce = (string)$p_Datos["trans_Payu_Responce"];

    }

    public function save($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        $datos = array(
            'trans_Id' => $this->_id,
            'trans_Fecha' => $this->_fecha,
            'trans_Fecha_Pago' => $this->_fecha_pago,
            'trans_Vencimiento' => $this->_vencimiento,
            'trans_Cliente' => $this->_cliente,
            'trans_Suscripcion' => $this->_suscripcion,
            'trans_Plan' => $this->_plan,
            'trans_Monto' => $this->_monto,
            'trans_Monto_Sin_IVA' => $this->_monto_sin_iva,
            'trans_Metodo' => $this->_metodo,
            'trans_Periodo' => $this->_periodo,
            'trans_Estado' => $this->_estado,
            'trans_Payu_Responce' => $this->_payu_responce
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('transacciones', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('transacciones', $datos, "trans_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }


}
