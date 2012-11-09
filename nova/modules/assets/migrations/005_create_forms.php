<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_forms extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'data_id' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'auto_increment' => TRUE),
			'data_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'data_char' => array(
				'type' => 'INT',
				'constraint' => 8),
			'data_user' => array(
				'type' => 'INT',
				'constraint' => 8),
			'data_value' => array(
				'type' => 'TEXT'),
			'data_updated' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		));
		$this->dbforge->add_key('data_id', true);
		$this->dbforge->create_table('characters_data');

		$this->dbforge->add_field(array(
			'field_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'field_type' => array(
				'type' => 'ENUM',
				'constraint' => "'text','select','textarea'",
				'default' => 'text'),
			'field_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_fid' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_class' => array(
				'type' => 'TEXT'),
			'field_label_page' => array(
				'type' => 'TEXT'),
			'field_value' => array(
				'type' => 'TEXT'),
			'field_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'field_display' => array(
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y'),
			'field_rows' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 5),
			'field_section' => array(
				'type' => 'INT',
				'constraint' => 8,
				'default' => 1)
		));
		$this->dbforge->add_key('field_id', true);
		$this->dbforge->create_table('characters_fields');

		$this->dbforge->add_field(array(
			'section_id' => array(
				'type' => 'INT',
				'constraint' => 8,
				'auto_increment' => TRUE),
			'section_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'section_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'section_tab' => array(
				'type' => 'INT',
				'constraint' => 5,
				'default' => 1)
		));
		$this->dbforge->add_key('section_id', true);
		$this->dbforge->create_table('characters_sections');

		$this->dbforge->add_field(array(
			'tab_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'auto_increment' => TRUE),
			'tab_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'tab_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'tab_link_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => 'one'),
			'tab_display' => array(
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y')
		));
		$this->dbforge->add_key('tab_id', true);
		$this->dbforge->create_table('characters_tabs');

		$this->dbforge->add_field(array(
			'value_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'value_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'value_field_value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'value_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''),
			'value_content' => array(
				'type' => 'TEXT'),
			'value_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('value_id', true);
		$this->dbforge->create_table('characters_values');

		/**
		 * Docking form
		 */
		$this->dbforge->add_field(array(
			'data_id' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'auto_increment' => TRUE),
			'data_docking_item' => array(
				'type' => 'INT',
				'constraint' => 5),
			'data_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'data_value' => array(
				'type' => 'TEXT'),
			'data_updated' => array(
				'type' => 'BIGINT',
				'constraint' => 20),
		));
		$this->dbforge->add_key('data_id', true);
		$this->dbforge->create_table('docking_data');

		$this->dbforge->add_field(array(
			'field_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'field_type' => array(
				'type' => 'ENUM',
				'constraint' => "'text','select','textarea'",
				'default' => 'text'),
			'field_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_fid' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_class' => array(
				'type' => 'TEXT'),
			'field_label_page' => array(
				'type' => 'TEXT'),
			'field_value' => array(
				'type' => 'TEXT'),
			'field_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => ''),
			'field_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'field_display' => array(
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y'),
			'field_rows' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 5),
			'field_section' => array(
				'type' => 'INT',
				'constraint' => 8,
				'default' => 1),
		));
		$this->dbforge->add_key('field_id', true);
		$this->dbforge->create_table('docking_fields');

		$this->dbforge->add_field(array(
			'section_id' => array(
				'type' => 'INT',
				'constraint' => 8,
				'auto_increment' => TRUE),
			'section_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'section_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('section_id', true);
		$this->dbforge->create_table('docking_sections');

		$this->dbforge->add_field(array(
			'value_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'value_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'value_field_value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'value_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''),
			'value_content' => array(
				'type' => 'TEXT'),
			'value_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('value_id', true);
		$this->dbforge->create_table('docking_values');

		/**
		 * Specs form
		 */
		$this->dbforge->add_field(array(
			'data_id' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'auto_increment' => TRUE),
			'data_item' => array(
				'type' => 'INT',
				'constraint' => 5),
			'data_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'data_value' => array(
				'type' => 'TEXT'),
			'data_updated' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		));
		$this->dbforge->add_key('data_id', true);
		$this->dbforge->create_table('specs_data');

		$this->dbforge->add_field(array(
			'field_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'field_type' => array(
				'type' => 'ENUM',
				'constraint' => "'text','select','textarea'",
				'default' => 'text'),
			'field_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_fid' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_class' => array(
				'type' => 'TEXT'),
			'field_label_page' => array(
				'type' => 'TEXT'),
			'field_value' => array(
				'type' => 'TEXT'),
			'field_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => ''),
			'field_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'field_display' => array(
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y'),
			'field_rows' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 5),
			'field_section' => array(
				'type' => 'INT',
				'constraint' => 8,
				'default' => 1)
		));
		$this->dbforge->add_key('field_id', true);
		$this->dbforge->create_table('specs_fields');

		$this->dbforge->add_field(array(
			'section_id' => array(
				'type' => 'INT',
				'constraint' => 8,
				'auto_increment' => TRUE),
			'section_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'section_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('section_id', true);
		$this->dbforge->create_table('specs_sections');

		$this->dbforge->add_field(array(
			'value_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'value_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'value_type' => array(
				'type' => 'ENUM',
				'constraint' => "'option'",
				'default' => 'option'),
			'value_field_value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'value_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''),
			'value_content' => array(
				'type' => 'TEXT'),
			'value_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('value_id', true);
		$this->dbforge->create_table('specs_values');

		/**
		 * Tour form
		 */
		$this->dbforge->add_field(array(
			'data_id' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'auto_increment' => TRUE),
			'data_tour_item' => array(
				'type' => 'INT',
				'constraint' => 5),
			'data_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'data_value' => array(
				'type' => 'TEXT'),
			'data_updated' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		));
		$this->dbforge->add_key('data_id', true);
		$this->dbforge->create_table('tour_data');

		$this->dbforge->add_field(array(
			'field_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'field_type' => array(
				'type' => 'ENUM',
				'constraint' => "'text','select','textarea'",
				'default' => 'text'),
			'field_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_fid' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
			'field_class' => array(
				'type' => 'TEXT'),
			'field_label_page' => array(
				'type' => 'TEXT'),
			'field_value' => array(
				'type' => 'TEXT'),
			'field_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => ''),
			'field_order' => array(
				'type' => 'INT',
				'constraint' => 5),
			'field_display' => array(
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y'),
			'field_rows' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 5),
		));
		$this->dbforge->add_key('field_id', true);
		$this->dbforge->create_table('tour_fields');

		$this->dbforge->add_field(array(
			'value_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'auto_increment' => TRUE),
			'value_field' => array(
				'type' => 'INT',
				'constraint' => 10),
			'value_field_value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'value_selected' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''),
			'value_content' => array(
				'type' => 'TEXT'),
			'value_order' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('value_id', true);
		$this->dbforge->create_table('tour_values');
	}

	public function down()
	{
		$this->dbforge->drop_table('characters_data');
		$this->dbforge->drop_table('characters_fields');
		$this->dbforge->drop_table('characters_sections');
		$this->dbforge->drop_table('characters_tabs');
		$this->dbforge->drop_table('characters_values');

		$this->dbforge->drop_table('docking_data');
		$this->dbforge->drop_table('docking_fields');
		$this->dbforge->drop_table('docking_sections');
		$this->dbforge->drop_table('docking_values');

		$this->dbforge->drop_table('specs_data');
		$this->dbforge->drop_table('specs_fields');
		$this->dbforge->drop_table('specs_sections');
		$this->dbforge->drop_table('specs_values');

		$this->dbforge->drop_table('tour_data');
		$this->dbforge->drop_table('tour_fields');
		$this->dbforge->drop_table('tour_values');
	}
}
