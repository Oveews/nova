<?php
/*
|---------------------------------------------------------------
| DOCKING MODEL
|---------------------------------------------------------------
|
| File: models/docking_model_base.php
| System Version: 1.0
|
| Model used to access the docking tables.
|
*/

class Docking_model_base extends Model {

	function Docking_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/*
	|---------------------------------------------------------------
	| RETRIEVE METHODS
	|---------------------------------------------------------------
	*/
	
	function get_docking_data($item = '', $field = '')
	{
		$this->db->from('docking_data');
		$this->db->where('data_docking_item', $item);
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return FALSE;
	}
	
	function get_docking_field_details($id = '')
	{
		$query = $this->db->get_where('docking_fields', array('field_id' => $id));
		
		return $query;
	}
	
	function get_docking_fields($section = '', $type = '')
	{
		$this->db->from('docking_fields');
		
		if (!empty($section))
		{
			$this->db->where('field_section', $section);
		}
		
		if (!empty($type))
		{
			$this->db->where('field_type', $type);
		}
		
		$this->db->where('field_display', 'y');
		$this->db->order_by('field_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_docked_item($id = '')
	{
		$this->db->from('docking');
		$this->db->where('docking_id', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row;
		}
		
		return FALSE;
	}
	
	function get_docked_items()
	{
		$this->db->from('docking');
		$this->db->order_by('docking_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_docking_sections()
	{
		$this->db->from('docking_sections');
		$this->db->order_by('section_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_docking_section_details($id = '')
	{
		$query = $this->db->get_where('docking_sections', array('section_id' => $id));
		
		return $query;
	}
	
	function get_docking_value_details($id = '')
	{
		$query = $this->db->get_where('docking_values', array('value_id' => $id));
		
		return $query;
	}
	
	function get_docking_values($field = '')
	{
		$this->db->from('docking_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_field_data($field = '', $item = '')
	{
		$this->db->from('docking_data');
		$this->db->where('data_docking_item', $item);
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function insert_docking_data($data = '')
	{
		$query = $this->db->insert('docking_data', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('docking_data');
		
		return $query;
	}
	
	function insert_docking_record($data = '')
	{
		$query = $this->db->insert('docking', $data);
		
		return $query;
	}
	
	function add_docking_field($data = '')
	{
		$query = $this->db->insert('docking_fields', $data);
		
		return $query;
	}
	
	function add_docking_field_data($data = '')
	{
		$query = $this->db->insert('docking_data', $data);
		
		$this->dbutil->optimize_table('docking_data');
		
		return $query;
	}
	
	function add_docking_field_value($data = '')
	{
		$query = $this->db->insert('docking_values', $data);
		
		return $query;
	}
	
	function add_tour_item($data = '')
	{
		$query = $this->db->insert('tour', $data);
		
		return $query;
	}
	
	function add_docking_section($data = '')
	{
		$query = $this->db->insert('docking_sections', $data);
		
		$this->dbutil->optimize_table('docking_sections');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_docking_field($id = '')
	{
		$query = $this->db->delete('docking_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('docking_fields');
		
		return $query;
	}
	
	function delete_docking_field_data($field = '')
	{
		$query = $this->db->delete('docking_data', array('data_field' => $field));
		
		$this->dbutil->optimize_table('docking_data');
		
		return $query;
	}
	
	function delete_docking_field_value($id = '')
	{
		$query = $this->db->delete('docking_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('docking_values');
		
		return $query;
	}
	
	function delete_tour_item($id = '')
	{
		$query = $this->db->delete('tour', array('tour_id' => $id));
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	function delete_docking_section($id = '')
	{
		$query = $this->db->delete('docking_sections', array('section_id' => $id));
		
		$this->dbutil->optimize_table('docking_sections');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_field_sections($old_id = '', $new_id = '')
	{
		$data = array('field_section' => $new_id);
		
		$this->db->where('field_section', $old_id);
		$query = $this->db->update('docking_fields', $data);
		
		$this->dbutil->optimize_table('docking_fields');
		
		return $query;
	}
	
	function update_tour_data($id = '', $data = '')
	{
		$this->db->where('data_id', $id);
		$query = $this->db->update('tour_data', $data);
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	function update_docking_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('docking_fields', $data);
		
		$this->dbutil->optimize_table('docking_fields');
		
		return $query;
	}
	
	function update_docking_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('docking_values', $data);
		
		$this->dbutil->optimize_table('docking_values');
		
		return $query;
	}
	
	function update_tour_item($id = '', $data = '')
	{
		$this->db->where('tour_id', $id);
		$query = $this->db->update('tour', $data);
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	function update_docking_section($id = '', $data = '')
	{
		$this->db->where('section_id', $id);
		$query = $this->db->update('docking_sections', $data);
		
		$this->dbutil->optimize_table('docking_sections');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_docked_items($status = '')
	{
		$this->db->from('docking');
		$this->db->where('docking_status', $status);
		
		return $this->db->count_all_results();
	}
}

/* End of file docking_model_base.php */
/* Location: ./application/models/base/docking_model_base.php */