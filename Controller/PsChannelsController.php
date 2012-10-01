<?php

class PsChannelsController extends PubSubAppController {
	
	public $components = array('Pusher.Pusher');

	public function implementedEvents() {
		return array(
			'PubSub.PublisherBehavior.afterPublished' => '_afterPublished',
		);
	}


	protected function _afterPublished($event) {
		die('After published !');
	}

}

?>