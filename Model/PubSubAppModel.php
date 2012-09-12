<?php

class PubSubAppModel extends AppModel {
	
	public $actsAs = array('Containable' => array(
		'recursive' => true
	));

}

?>