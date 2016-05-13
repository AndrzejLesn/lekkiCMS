<?php

	defined('IN_LCMS') or exit('Access denied!');

	function social_info() {
		return array(
			'name'	=>	'social',
			'description'	=>	'Social info',
			'author'	=>	'Wipstudio',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}

	function social_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'FB'),array('name'=>'TW'),array('name'=>'YT'),array('name'=>'G+'),array('name'=>'EM'),array('name'=>'tel'),array('name'=>'adr'),array('name'=>'adr1'),array('name'=>'adr2'));
		$tablename = 'social';
		if (!$db->_table_exists('db', $tablename)){
			if($db->create_table($tablename,$fields)){
				$newRecord = array(NULL,'#','#','#','#','admin@localhost.hp','777-77-77','Diabelna 6/9','Warszwa','90-210');
				$db->insert($tablename, $newRecord);
				
			}
		}
		
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'iconpack'),array('name'=>'size'));
		$tablename = 'social_cfg';
		if (!$db->_table_exists('db', $tablename)){
			if($db->create_table($tablename,$fields)){
				$newRecord = array(NULL,'sketch','40');
				$db->insert($tablename, $newRecord);
				
			}
		}

	}

	function social_uninstall() {
		global $db;
		$db->drop_table('social');
	$db->drop_table('social_cfg');
	}
	
?>
