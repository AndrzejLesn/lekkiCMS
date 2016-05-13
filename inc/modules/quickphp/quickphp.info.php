<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Informations about this module
	function quickphp_info() {
		return array(
			'name'	=>	'QuickPHP',
			'description'	=>	'Stwórz funckję i wywołuj ją kiedy chcesz',
			'author'	=>	'MaTvA',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}

	//Installation
	function quickphp_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'name'),array('name'=>'get_name'),array('name'=>'code'));
		$tablename = 'quickphp';
		if (!$db->_table_exists('db', $tablename)){
		    if($db->create_table($tablename,$fields)){
		    	$newRecord = array(NULL,'Hello world','hello_world','return "Hello World!";');
		        $db->insert($tablename, $newRecord);
		    }
		}
	}

	//Uninstallation
	function quickphp_uninstall() {
		global $db;
		$db->drop_table('quickphp');
	}

?>
