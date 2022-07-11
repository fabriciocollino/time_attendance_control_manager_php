<?php





class enPuntoSessionHandler {
    public $lifeTime;
    public $memcache;
    public $initSessionData;
    private $_path;
    private $_debug;

    function __construct($p_path) {

        register_shutdown_function("session_write_close");

        $this->memcache = new Memcache;
        $this->lifeTime = 0;
        $this->initSessionData = null;
        $this->_path = $p_path;

        $this->_debug = "Object created, path: ".$this->_path."<br />";

        return true;
    }

    function open($savePath,$sessionName) {
        $sessionID = session_id();
        if ($sessionID !== "") {
            $this->initSessionData = $this->read($sessionID);
        }

        $this->_debug .= "session open id: ".$sessionID."<br />";

        return true;
    }

    function close() {
        $this->lifeTime = null;
        $this->memcache = null;
        $this->initSessionData = null;

        $this->_debug .= "session closed"."<br />";

        return true;
    }

    function read($sessionID) {
        $data = $this->memcache->get($sessionID);

        $this->_debug .= "session read id: ".$sessionID."<br />";

        if ($data === false) {
            //no se encontro la sesion en el memcache, la busco en el storage
            $this->_debug .= "session read, no data in memcache"."<br />";
            if(file_exists($this->_path . $sessionID)) {

                $this->_debug .= "session read, readed from storage"."<br />";
                $data = file_get_contents($this->_path . $sessionID);

                $this->memcache->set($sessionID, $data, false, $this->lifeTime);
            }else {
                $this->_debug .= "session read, no data in storage, returning false"."<br />";
                return false;
            }
        }


        return $data;
    }

    function write($sessionID,$data) {

        $result = $this->memcache->set($sessionID,$data,false,$this->lifeTime);

        //TODO fijarse si aca, puedo evitar escribir en el storage cada vez. (quizas puedo guardar solo el user id en el storage y que los otros datos se vayan a la mierda)

        //probar hacer que no se guarde siempre,sino una sola vez. y que cuando lo lea si la data es diferente que se joda


        $this->_debug .= "session write"."<br />";
        if ($this->initSessionData !== $data) {  //si la data cambio, la actualizo en el storage
       //     file_put_contents($this->_path.$sessionID,$data);
            $this->_debug .= "session write to storage"."<br />";
        }

        return $result;
    }

    function destroy($sessionID) {

        $this->memcache->delete($sessionID);
        $this->_debug .= "session destroyed from memcache"."<br />";
//echo "estoy here";
        if(file_exists($this->_path . $sessionID)) {
            $this->_debug .= "session destroyed from storage"."<br />";
            unlink($this->_path . $sessionID);
//echo "unlinked".$this->_path.$sessionID;
        }

        return true;
    }

    function gc($maxlifetime) {

        //TODO hacer el gc para esto
        $this->_debug .= "session gc"."<br />";

        return true;
    }

    function getDebugInfo(){
        return $this->_debug;
    }
}


/*
ini_set("session.gc_maxlifetime",60 * 30); # 30 minutes
session_set_cookie_params(0,"/",".myapp.com",false,true);
session_name("MYAPPSESSION");
$sessionHandler = new SessionHandler();
session_set_save_handler(array (&$sessionHandler,"open"),array (&$sessionHandler,"close"),array (&$sessionHandler,"read"),array (&$sessionHandler,"write"),array (&$sessionHandler,"destroy"),array (&$sessionHandler,"gc"));
session_start();
*/

