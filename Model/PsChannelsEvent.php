<?php
App::uses('PubSubAppModel', 'PubSub.Model');
/**
 * PsChannelsEvent Model
 *
 * @property PsChannel $PsChannel
 * @property PsEvent $PsEvent
 */
class PsChannelsEvent extends PubSubAppModel {

	public $useTable = 'ps_channels_ps_events';

	public $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PsChannel' => array(
			'className' => 'PsChannel',
			'foreignKey' => 'ps_channel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PsEvent' => array(
			'className' => 'PsEvent',
			'foreignKey' => 'ps_event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
