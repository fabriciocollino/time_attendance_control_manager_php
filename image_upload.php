<?php

require_once(dirname(__FILE__) . '/_ruta.php');


  $str = file_get_contents('php://input');
  
  echo $filename = md5(time().uniqid()).".jpg";
  
  file_put_contents(GS_CLIENT_TEMP_FOLDER.$filename,$str);
  



