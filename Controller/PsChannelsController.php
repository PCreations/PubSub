<?php

class PsChannelsController extends PubSubAppController {
	
	public $components = array('Pusher.Pusher');


	protected function _afterPublished($event) {
		die('After published !');
	}

}

?>