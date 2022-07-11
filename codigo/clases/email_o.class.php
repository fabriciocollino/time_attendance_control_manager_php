<?php


class Email_O
{

    private $_id;
    private $_fecha;
    private $_destinatario;
    private $_sujeto;
    private $_cuerpo;
    private $_estado;
    private $_grupal;
    private $_grupo;
    private $_adjunto;
    private $_destinatarionombre;
    private $_subdominio;
    private $_from;

    private $_errores;

    public function __construct($p_destinatario = '', $p_sujeto = '', $p_cuerpo = '', $p_estado = 0, $p_grupal = 0, $p_grupo = 0, $adjunto = '', $from='')
    {
        $this->_id = 0;
        $this->_destinatario = $p_destinatario;
        $this->_destinatarionombre = '';
        $this->_subdominio = '';
        $this->_sujeto = $p_sujeto;
        $this->_cuerpo = $p_cuerpo;
        $this->_estado = $p_estado;
        $this->_grupal = $p_grupal;
        $this->_grupo = $p_grupo;
        $this->_fecha = 0;
        $this->_adjunto = $adjunto;
        $this->_from = $from;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($p_id)
    {
        $p_id = (integer)$p_id;
        $this->_id = $p_id;
    }


    public function getDestinatario()
    {
        return $this->_destinatario;
    }

    public function setDestinatario($p_destinatario)
    {
        $p_destinatario = (string)$p_destinatario;
        $this->_destinatario = $p_destinatario;
    }

    public function getSujeto()
    {
        return $this->_sujeto;
    }

    public function setSujeto($p_sujeto)
    {
        $p_sujeto = (string)$p_sujeto;
        $this->_sujeto = $p_sujeto;
    }

    public function getDestinatarioNombre()
    {
        return $this->_destinatarionombre;
    }

    public function setDestinatarioNombre($p_destinatarionombre)
    {
        $p_destinatarionombre = (string)$p_destinatarionombre;
        $this->_destinatarionombre = $p_destinatarionombre;
    }

    public function getSubdominio()
    {
        return $this->_subdominio;
    }

    public function setSubDominio($p_subdominio)
    {
        $p_subdominio = (string)$p_subdominio;
        $this->_subdominio = $p_subdominio;
    }


    public function getFrom()
    {
        return $this->_from;
    }

    public function setFrom($p_From)
    {
        $p_From = (string)$p_From;
        $this->_from = $p_From;
    }

    public function getCuerpo()
    {
        return $this->_cuerpo;
    }

    public function setCuerpo($p_cuerpo)
    {
        $p_cuerpo = (string)$p_cuerpo;
        $this->_cuerpo = $p_cuerpo;
    }

    public function getEstado()
    {
        return $this->_estado;
    }

    public function getEstado_S()
    {

        if ($this->_estado == 1) return _("ESPERANDO");
        else if ($this->_estado == 2) return _("ENVIADO");
        else if ($this->_estado == 3) return _("ERROR");
    }

    public function setEstado($p_estado)
    {
        $p_estado = (integer)$p_estado;
        $this->_estado = $p_estado;
    }

    public function getGrupal()
    {
        return $this->_grupal;
    }

    public function setGrupal($p_grupal)
    {
        $p_grupal = (integer)$p_grupal;
        $this->_grupal = $p_grupal;
    }

    public function getGrupo()
    {
        return $this->_grupo;
    }

    public function setGrupo($p_grupo)
    {
        $p_grupo = (integer)$p_grupo;
        $this->_grupo = $p_grupo;
    }

    public function getAdjunto()
    {
        return $this->_adjunto;
    }

    public function setAdjunto($p_adjunto)
    {
        $p_adjunto = (string)$p_adjunto;
        $this->_adjunto = $p_adjunto;
    }


    public function getFecha($p_Format = null)
    {
        if (!is_null($p_Format) && is_string($p_Format)) {
            if (is_int($this->_fecha)) {
                return date($p_Format, $this->_fecha);
            } else {
                return $this->_fecha;
            }
        }
        return $this->_fecha;
    }


    public function setFecha($p_Hora, $p_Format, $p_Ignore = false)
    {
        if (!$p_Ignore) {
            $this->_fecha = $p_Hora;
        } else {
            $this->_fecha = 0;
        }
    }

    public function loadArray($p_Datos)
    {
        $this->_id = (integer)$p_Datos["ema_Id"];
        $this->_fecha = (is_null($p_Datos["ema_Fecha"])) ? null : strtotime($p_Datos["ema_Fecha"]);
        $this->_destinatario = (string)$p_Datos["ema_Destinatario"];
        $this->_sujeto = (string)$p_Datos["ema_Sujeto"];
        $this->_cuerpo = (string)$p_Datos["ema_Cuerpo"];
        $this->_estado = (integer)$p_Datos["ema_Estado"];
        $this->_grupal = (integer)$p_Datos["ema_Grupal"];
        $this->_grupo = (integer)$p_Datos["ema_Grupo"];
        $this->_adjunto = (string)$p_Datos["ema_Adjunto"];
        $this->_from = (string)$p_Datos["ema_From"];

    }

    public function save($p_Debug)
    {
        /* @var $cnn mySQL */
        $cnn = Registry::getInstance()->DbConn;

        $datos = array(
            'ema_Id' => $this->_id,
            'ema_Fecha' => $this->_fecha,
            'ema_Destinatario' => $this->_destinatario,
            'ema_Sujeto' => $this->_sujeto,
            'ema_Cuerpo' => $this->_cuerpo,
            'ema_Estado' => $this->_estado,
            'ema_Grupal' => $this->_grupal,
            'ema_Grupo' => $this->_grupo,
            'ema_Adjunto' => $this->_adjunto,
            'ema_From' => $this->_from
        );

        if ($this->_id == 0) {
            $resultado = $cnn->Insert('email', $datos);
            if ($resultado !== false) {
                $this->_id = $cnn->Devolver_Insert_Id();
            }
        } else {
            $resultado = $cnn->Update('email', $datos, "ema_Id = {$this->_id}");
        }

        if ($resultado === false) {
            $this->_errores['mysql'] = $cnn->get_Error($p_Debug);
        }

        return $resultado;

    }


    public function enviar()
    {
        //TODO: antes de enviar, chequear que todos los campos sean correctos.


        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        //datos del servidor
        $mail->Host = 'localhost';
        $mail->From = _("notificaciones") . "@" . $mail->Host;

        if (Config_L::obtenerPorParametro('usar_smtp')->getValor()) {

            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->Host = Config_L::obtenerPorParametro('host_smtp')->getValor();
            $mail->SMTPAuth = true;
            $mail->Username = Config_L::obtenerPorParametro('usuario_smtp')->getValor();
            $mail->Password = Config_L::obtenerPorParametro('password_smtp')->getValor();
            $mail->Port = Config_L::obtenerPorParametro('puerto_smtp')->getValor();
            $mail->From = Config_L::obtenerPorParametro('usuario_smtp')->getValor();

            if (Config_L::p('usar_tls'))
                $mail->SMTPSecure = 'tls';
        }

        if($this->_from==''){
            $mail->FromName = Config_L::obtenerPorParametro('from_smtp')->getValor();
        }else{
            $mail->FromName  = $this->_from;
        }

        $mail->AddReplyTo("noreply@enpuntocontrol.com");


        //TAGS
        $TAG_USER_NAME = '';
        $TAG_HEADER_TITLE = '';
        $TAG_BODY_TITLE = '';
        $TAG_BODY = '';
        $TAG_FOOTER_NOTE = '';

        $TAG_SUBDOMAIN = $this->_subdominio;

/*
        if ($this->_grupal) {
            $o_Grupo = Grupo_L::obtenerPorId($this->_grupo);
            if (!is_null($o_Grupo)) {
                $a_emails = Grupo_L::obtenerListaEmailsPorId($this->_grupo);
                if (!is_null($a_emails)) {
                    $TAG_USER_NAME = '';
                    foreach ($a_emails as $email)
                        $mail->AddAddress($email);
                }
            }
        } else {
            $mail->AddAddress($this->_destinatario);
            $o_usuario = Usuario_L::obtenerPorEmail($this->_destinatario);  //TODO: no va personas aca tmb?
            if (!is_null($o_usuario)) {
                $TAG_USER_NAME = $o_usuario->getNombre();
            }
        }
*/
//para el manager no me hace falta lo anterior.
        $mail->AddAddress($this->_destinatario);
        $TAG_USER_NAME=$this->_destinatarionombre;

        $TAG_HEADER_TITLE = $this->_sujeto;

        //por ahora no lo uso a este
        //$TAG_BODY_TITLE = $this->_sujeto;

        $TAG_BODY = $this->_cuerpo;

        $TAG_FOOTER_NOTE = "Email enviado el" . ':' . " " . date('d-m-Y', time()) . ", a las " . date('H:i:s', time());
        if ($this->_grupal) {
            $o_Grupo = Grupo_L::obtenerPorId($this->_grupo);
            $TAG_FOOTER_NOTE.="<br/><br/>Recibes este email porque eres parte del grupo ".$o_Grupo->getDetalle();
        }

        $mail->Subject = $this->_sujeto;
        //$mail->Body = $this->_cuerpo."<br><br>"._("Fecha").':'." ".date('d-m-Y  -  H:i:s',time());
        //$mail->Body = $this->_cuerpo."<br><br>"."Email enviado el".':'." ".date('d-m-Y',time()).", a las ".date('H:i:s',time());
        //$this->_cuerpo = $this->_cuerpo."<br><br>".


        $TEMPLATE = Config_L::email('general_email_tagged');

        $a_TAGS = array(
            '##HEADER_TITLE##',
            '##BODY_TITLE##',
            '##USER_NAME##',
            '##BODY##',
            '##FOOTER_NOTE##',
            '##SUBDOMAIN##'
        );

        $a_TAGS_r = array(
            $TAG_HEADER_TITLE,
            $TAG_BODY_TITLE,
            $TAG_USER_NAME,
            $TAG_BODY,
            $TAG_FOOTER_NOTE,
            $TAG_SUBDOMAIN
        );

        $cuerpoHTML = str_replace($a_TAGS, $a_TAGS_r, $TEMPLATE);


        $mail->IsHTML(true);
        $mail->Body = $cuerpoHTML;


        $mail->AltBody = strip_tags($this->_cuerpo); // Este es el contenido alternativo sin html

        if ($this->_adjunto != '') {
            $mail->AddAttachment($this->_adjunto);
        }


        $mail->Send();

        //print_r($mail);

        //elimino el pdf
        if ($this->_adjunto != '') {
            if (file_exists($this->_adjunto))
                unlink($this->_adjunto);
        }


    }


}
