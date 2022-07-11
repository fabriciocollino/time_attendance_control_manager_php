<?php


class Tarjetas_O
{

    private $_id;
    private $_cliente;
    private $_tarjeta;
    private $_cc_token;
    private $_cc_masked_number;
    private $_cc_ccv;
    private $_cc_month;
    private $_cc_year;
    private $_default;


    private $_errores;

    public function __construct() {
        $this->_id = 0;
        $this->_cliente = 0;
        $this->_tarjeta = '';
        $this->_cc_token = '';
        $this->_cc_masked_number = '';
        $this->_cc_ccv = '';
        $this->_cc_month = '';
        $this->_cc_year = '';
        $this->_default = 0;

    }

    public function getId() {
        return $this->_id;
    }

    public function setId($p_id) {
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente($p_cliente) {
        $p_cliente = (integer)$p_cliente;
        $this->_cliente = $p_cliente;
    }

    public function getTarjeta() {
        return $this->_tarjeta;
    }

    public function setTarjeta($p_tarjeta) {
        $p_tarjeta = (string)$p_tarjeta;
        $this->_tarjeta = $p_tarjeta;
    }

    public function getToken() {
        return $this->_cc_token;
    }

    public function setToken($p_token) {
        $p_token = (string)$p_token;
        $this->_cc_token = $p_token;
    }

    public function getMaskedNumber() {
        return $this->_cc_masked_number;
    }

    public function setMaskedNumber($p_masked_number) {
        $p_masked_number = (string)$p_masked_number;
        $this->_cc_masked_number = $p_masked_number;
    }

    public function getMonth() {
        return $this->_cc_month;
    }

    public function setMonth($p_month) {
        $p_month = (string)$p_month;
        $this->_cc_month = $p_month;
    }

    public function getYear() {
        return $this->_cc_year;
    }

    public function setYear($p_year) {
        $p_year = (string)$p_year;
        $this->_cc_year = $p_year;
    }

    public function getCVC() {
        return $this->_cc_ccv;
    }

    public function setCVC($p_cvc) {
        $p_cvc = (string)$p_cvc;
        $this->_cc_ccv = $p_cvc;
    }

    public function getDefault() {
        return $this->_default;
    }

    public function setDefault($p_default) {
        $p_default = (integer)$p_default;
        $this->_default = $p_default;
    }

    public function loadArray($p_Datos) {
        $this->_id = (integer)$p_Datos["tar_Id"];
        $this->_cliente = (integer)$p_Datos["tar_Cliente"];
        $this->_tarjeta = (string)$p_Datos["tar_Tarjeta"];
        $this->_cc_token = (string)$p_Datos["tar_CC_Token"];
        $this->_cc_masked_number = (string)$p_Datos["tar_CC_MaskedNumber"];
        $this->_cc_ccv = (string)$p_Datos["tar_CC_CCV"];
        $this->_cc_month = (string)$p_Datos["tar_CC_Month"];
        $this->_cc_year = (string)$p_Datos["tar_CC_Year"];
        $this->_default = (integer)$p_Datos["tar_Default"];

    }

    public function save($p_Debug = false) {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConnMGR;

        $datos = array(
            'tar_Id' => $this->_id,
            'tar_Cliente' => $this->_cliente,
            'tar_Tarjeta' => $this->_tarjeta,
            'tar_CC_Token' => $this->_cc_token,
            'tar_CC_MaskedNumber' => $this->_cc_masked_number,
            'tar_CC_CCV' => $this->_cc_ccv,
            'tar_CC_Month' => $this->_cc_month,
            'tar_CC_Year' => $this->_cc_year,
            'tar_DEFAULT' => $this->_default
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('tarjetas', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('tarjetas', $datos, "tar_Id = {$this->_id}");
        }


        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }


}
