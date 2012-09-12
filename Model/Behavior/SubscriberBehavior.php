<?php

App::uses('String', 'Utility');

class SubscriberBehavior extends ModelBehavior {

	protected $ChannelModel;

	protected $SubscribeModel;

	public function setup(Model $Model, $settings = array()) {
	    if (!isset($this->settings[$Model->alias])) {
	        $this->settings[$Model->alias] = array();
	    }
	    $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);

	    /* Instantiate needed models */
	    $this->ChannelModel = ClassRegistry::init('PubSub.PsChannel');
	    $this->SubscribeModel = ClassRegistry::init('PubSub.PsSubscribe');
	}

	public function subscribe(Model $Model, $channelName) {
		if(!$Model->id)
			throw new CakeException('No entity initialized for model ' . $Model->alias);

		$channel = $this->ChannelModel->findByName($channelName);
		if(!$channel) {
			throw new CakeException('Channel ' . $channelName . ' doesn\'t exist');
		}

		$subscription = array(
			'PsSubscribe' => array(
				'id' => String::uuid(),
				'ps_channel_id' => $channel['PsChannel']['id'],
				'model' => $Model->alias,
				'foreign_key' => $Model->id
			)
		);

		if(!$this->SubscribeModel->save($subscription)) {
			throw new CakeException('Unable to save Subscription');
		}

		$Model->getEventManager()->dispatch(new CakeEvent('PubSub.SubscriberBehavior.afterSubscribed', $Model, array($subscription)));
	}

	public function findSubscriptions($Model, $options = array()) {
		$Model->bindModel(
			array(
				'hasMany' => array(
					'PsSubscribe' => array(
						'className' => 'PsSubscribe',
						'foreignKey' => 'foreign_key',
						'dependent' => false,
						'conditions' => array(
							'PsSubscribe.model' => $Model->alias,
							'PsSubscribe.foreign_key' => $Model->id
						),
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'exclusive' => '',
						'finderQuery' => '',
						'counterQuery' => ''
					)
				)
			),
			false
		);

		$options['conditions'][$Model->alias . '.' . $Model->primaryKey] = $Model->id;
		$options['contain']['PsSubscribe'] = array(
			'fields' => array(
				'PsSubscribe.ps_channel_id',
				'PsSubscribe.created'
			),
			'PsChannel.name'
		);

		return $Model->find('all', $options);
	}
}

?>