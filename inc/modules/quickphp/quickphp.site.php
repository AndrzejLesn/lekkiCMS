<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	$query = $db->select('quickphp');
	if($query) {
		foreach($query as $record) {
			$core->replace('{{func.'.$record['get_name'].'}}',eval(str_replace('\n', " ",$record['code'])));
		}
	}

?>
