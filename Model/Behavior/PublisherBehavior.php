<?php

App::uses('String', 'Utility');

class PublisherBehavior extends ModelBehavior {

	protected $ChannelModel;

	public function setup(Model $Model, $settings = array()) {
	    if (!isset($this->settings[$Model->alias])) {
	        $this->settings[$Model->alias] = array(
	            'channelType' => $Model->alias,
	        );
	    }
	    $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);

	    /* Instantiate needed models */
	    $this->ChannelModel = ClassRegistry::init('PubSub.PsChannel');
	}

	public function publish(Model $Model, $channelName, $eventName, $channelType = null) {
		if(!$Model->id)
			throw new CakeException('No entity initialized for model ' . $Model->alias);

		$channelType = ($channelType == null) ? $this->settings[$Model->alias]['channelType'] : $channelType;
		$event = array(
			'PsEvent' => array(
				'id' => String::uuid(),
				'name' => $eventName,
				'model' => $Model->alias,
				'foreign_key' => $Model->id
			)
		);

		$currentChannel = $this->_channelRoutine($Model, $channelName, $channelType);
		
	}

	protected function _channelRoutine(Model $model, $channelName) {
		$channelExists = $this->ChannelModel->channelExists($channelName);
		$channelID = String::uuid();
		if(!$channelExists) {
			if($this->ChannelModel->save(array(
				'PsChannel' => array(
					'id' => $channelID,
					'name' => $channelName
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
		return $this->Channel->findByName($channelName);
	}
}

?>