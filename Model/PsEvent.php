<?php
App::uses('PubSubAppModel', 'PubSub.Model');
/**
 * PsEvent Model
 *
 * @property PsChannel $PsChannel
 */
class PsEvent extends PubSubAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'PsChannel' => array(
			'className' => 'PsChannel',
			'joinTable' => 'ps_channels_ps_events',
			'foreignKey' => 'ps_event_id',
			'associationForeignKey' => 'ps_channel_id',
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

}
