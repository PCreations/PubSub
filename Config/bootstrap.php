<?php

/*App::uses('CakeEventManager', 'Event');
App::uses('PsChannelsController', 'PubSub.Controller');
CakeEventManager::instance()->attach(new ActivityEventListener());*/
Configure::write('PubSub', array(
	'behavior' => array(
		'className' => 'PusherBehavior',
		'namespace' => 'Pusher.Model/Behavior',
		'load' => 'Pusher.Pusher'
	)
));
?>