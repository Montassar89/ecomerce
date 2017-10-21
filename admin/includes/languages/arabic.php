<?php 
  function lang($phrase){

  	static $lang = array(

        'MESSAGE' => 'Welcome arabic',
        'ADMIN' => 'Administrator'
);
  	return $lang[$phrase];
  }
?>