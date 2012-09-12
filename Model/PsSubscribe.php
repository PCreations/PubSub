<?php
App::uses('PubSubAppModel', 'PubSub.Model');
/**
 * PsSubscribe Model
 *
 * @property PsChannel $PsChannel
 */
class PsSubscribe extends PubSubAppModel {

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
		)
	);
}
