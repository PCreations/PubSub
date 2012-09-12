<?php

App::uses('String', 'Utility');

class PublisherBehavior extends ModelBehavior {

	protected $ChannelModel;

	protected $EventModel;

	public function setup(Model $Model, $settings = array()) {
	    if (!isset($this->settings[$Model->alias])) {
	        $this->settings[$Model->alias] = array(
	            'channelType' => $Model->alias,
	        );
	    }
	    $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);

	    /* Instantiate needed models */
	    $this->ChannelModel = ClassRegistry::init('PubSub.PsChannel');
	    $this->EventModel = ClassRegistry::init('PubSub.PsEvent');
	}

	public function publish(Model $Model, $channelName, $eventName, $eventData, $channelType = null) {
		if(!$Model->id)
			throw new CakeException('No entity initialized for model ' . $Model->alias);

		$channelType = ($channelType == null) ? $this->settings[$Model->alias]['channelType'] : $channelType;
		$eventID = String::uuid();
		$event = array(
			'PsEvent' => array(
				'id' => $eventID,
				'name' => $eventName,
				'data' => json_encode($eventData),
				'model' => $Model->alias,
				'foreign_key' => $Model->id
			)
		);

		if(!$this->EventModel->save($event)) {
			throw new CakeException('Unable to save Event');
		}

		$currentChannel = $this->_channelRoutine($Model, $channelName, $channelType);

		/* Save association */
		if(!$this->ChannelModel->PsChannelsEvent->save(
			array(
				'PsChannelsEvent' => array(
					'ps_channel_id' => $currentChannel['PsChannel']['id'],
					'ps_event_id' => $eventID
				)
			)
		)) {
			throw new CakeException('Unable to save association between Channel and Event');
		}

		$Model->getEventManager()->dispatch(new CakeEvent('PubSub.PublisherBehavior.afterPublished', $Model, array($currentChannel, $event)));
	}

	protected function _channelRoutine(Model $Model, $channelName, $channelType) {
		$channelExists = $this->ChannelModel->channelExists($channelName);
		$channelID = String::uuid();
		if(!$channelExists) {
			if($this->ChannelModel->save(array(
				'PsChannel' => array(
					'id' => $channelID,
					'name' => $channelName,
					'type' => $channelType,
				)
			))){
				$channel = $this->ChannelModel->read();
				return $channel;
			}
			else {
				throw new CakeException('Unable to save Channel');
			}
		}
		return $this->ChannelModel->findByName($channelName);
	}
}

?>