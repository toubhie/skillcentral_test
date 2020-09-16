<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

// INSERT VERSION NUMBER INSIDE SETTINGS TABLE
$settings_data = array( 'value' => '4.0');
$CI->db->where('key', 'version');
$CI->db->update('settings', $settings_data);


// ADD NEW is_instructor COLUMN INSINDE USERS TABLE
$is_instructor_field = array(
	'is_instructor' => array(
		'type' => 'INT',
		'constraint' => 11,
		'default' => 0,
	)
);
$this->dbforge->add_column('users', $is_instructor_field);

// CREATING APPLICATIONS TABLE
$applications_fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 11,
		'unsigned' => TRUE,
		'auto_increment' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'user_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'address' => array(
		'type' => 'LONGTEXT',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'phone' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'message' => array(
		'type' => 'LONGTEXT',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'document' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'status' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => 0,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	)
);
$CI->dbforge->add_field($applications_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('applications', TRUE);

// CREATING PAYOUT TABLE
$payout_fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 11,
		'unsigned' => TRUE,
		'auto_increment' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'user_id' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'payment_type' => array(
		'type' => 'VARCHAR',
		'constraint' => '255',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'amount' => array(
		'type' => 'DOUBLE',
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'date_added' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'last_modified' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => null,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	),
	'status' => array(
		'type' => 'INT',
		'constraint' => '11',
		'default' => 0,
		'null' => TRUE,
		'collation' => 'utf8_unicode_ci'
	)
);
$CI->dbforge->add_field($payout_fields);
$CI->dbforge->add_key('id', TRUE);
$attributes = array('collation' => "utf8_unicode_ci");
$CI->dbforge->create_table('payout', TRUE);

// INSERT instructor_application_note INSIDE SETTINGS TABLE
$instructor_application_note = array( 'key' => 'instructor_application_note', 'value' => 'Fill all the fields carefully and share if you want to share any document with us it will help us to evaluate you as an instructor.' );
$CI->db->insert('settings', $instructor_application_note);

// REGISTER USERS AS INSTRUCTOR WHO HAS AT LEAST ONE COURSE MADE
$users = $CI->db->get('users')->result_array();
foreach ($users as $user) {
	$number_of_courses = $CI->db->get_where('course', array('user_id' => $user['id']))->num_rows();
	if ($number_of_courses > 0) {
		$updater = array('is_instructor' => 1);
	}else{
		$updater = array('is_instructor' => 0);
	}
	$CI->db->where('id', $user['id']);
	$CI->db->update('users', $updater);
}
?>
