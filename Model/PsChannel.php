<?php
App::uses('PubSubAppModel', 'PubSub.Model');
/**
 * PsChannel Model
 *
 * @property PsSubscribe $PsSubscribe
 * @property PsEvent $PsEvent
 */
class PsChannel extends PubSubAppModel {

	public $actsAs = array('Containable');
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PsSubscribe' => array(
			'className' => 'PsSubscribe',
			'foreignKey' => 'ps_channel_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'PsEvent' => array(
			'className' => 'PsEvent',
			'joinTable' => 'ps_channels_ps_events',
			'foreignKey' => 'ps_channel_id',
			'associationForeignKey' => 'ps_event_id',
			'with' => 'PubSub.PsChannelsEvent',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	public function channelExists($channelName) {
		$result = $this->find('first', array(
			'conditions' => array(
				'PsChannel.name' => $channelName,
			)
		));
		return !empty($result);
	}
}
