<?php
/**
 * Rank Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Rank extends \Model {
	
	public static $_table_name = 'ranks_';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'info_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'group_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'base' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'pip' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'info' => array(
			'model_to' => '\\Model_Rank_Info',
			'key_to' => 'id',
			'key_from' => 'info_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'group' => array(
			'model_to' => '\\Model_Rank_Group',
			'key_to' => 'id',
			'key_from' => 'group_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Rank' => array(
			'events' => array('before_delete', 'after_insert', 'after_update', 'before_save')
		),
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. The _init method is necessary since PHP won't
	 * allow creating an object project that's dynamic. This method changes
	 * the name of the table once the class is loaded.
	 *
	 * @internal
	 * @return	void
	 */
	public static function _init()
	{
		static::$_table_name = static::$_table_name.\Config::get('nova.genre');
	}
}