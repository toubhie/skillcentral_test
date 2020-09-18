<?php
	$CI = get_instance();
	$CI->load->database();
	$CI->load->dbforge();

	//insert data in settings table
	$settings_data = array( 'value' => '3.3' );
	$CI->db->where('key', 'version');
	$CI->db->update('settings', $settings_data);
?>
