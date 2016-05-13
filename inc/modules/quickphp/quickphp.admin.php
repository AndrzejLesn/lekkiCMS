<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Pages of this module
	function quickphp_pages() {
		$pages[] = array(
			'func'  => 'quickphp_list',
			'title' => 'Lista funkcji'
		);
		$pages[] = array(
			'func'  => 'quickphp_add',
			'title' => 'Dodaj funkcję'
		);
		return $pages;
	}

	function quickphp_list() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_GET['q']) && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']);
            $query = $db->select('quickphp', $condtion);
            if($query) {
				if($_GET['q']=='edit') {
					if(isset($_POST['save'])) {
						if(!empty($_POST['name']) && !empty($_POST['code'])) {
							$updateRecord = array($_POST['id'], $_POST['name'], changeSigns($_POST['name']), htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes($_POST['code']))));
							if($db->update('quickphp', $condtion, $updateRecord)) {
								$core->notify('Funkcja została zapisana',1);
							}
						}
					} else {
						$condtion = array('id'=>$_GET['id']);
           				$query = $db->select('quickphp', $condtion);
						$record = $query[0];
						$result .= quickphp_form($record);
					}
				}
				if($_GET['q']=='del') {
					if($db->delete('quickphp', $condtion)) {
						$core->notify('Funkcja została usunięta',1);
					}
				}
			} else $core->notify("Funkcja nie mogła zostać usunięta",2);
		}
		$query = $db->select('quickphp');
		krsort($query);
		$result .= '<table><thead>';
		$result .= '<tr><td>Nazwa funkcji</td><td>Kod wywołujący</td><td>Opcje</td></tr>';
		$result .= '</thead><tbody>';
		foreach($query as $record) {
			$result .= '<tr><td>'.$record['name'].'</td><td>{{func.'.$record['get_name'].'}}</td><td><a href="?go=quickphp&q=edit&id='.$record['id'].'" class="icon">Z</a> <a href="?go=quickphp&q=del&id='.$record['id'].'" class="icon">l</a></td></tr>';
		}
		$result .= '</tbody> </table>';
		return $result;

	}

	function quickphp_add() {
		global $lang, $db, $core;
		$result = NULL;
		$result = quickphp_form();
		if(isset($_POST['save'])) {
			if(!empty($_POST['name']) && !empty($_POST['code'])) {
				if(!$db->select('quickphp',array('name'=>$_POST['name'])) && !$db->select('quickphp',array('get_name'=>changeSigns($_POST['name'])))) {
					$newRecord = array(NULL, $_POST['name'], changeSigns($_POST['name']), htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes($_POST['code']))));
					if($db->insert('quickphp', $newRecord)) {
						$core->notify('Funkcja została zapisana',1);
					}
				} else $core->notify("Nazwa funkcji jest już w użyciu",2);
			} else $core->notify("Wszystkie pola są wymagane",2);
		}
		return $result;
	}
	
	function quickphp_form($data = array()) {
		$result = '<form name="example" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>Nazwa funkcji</label>';
		$result .= '<input type="text" name="name" value="'.@$data['name'].'" />';
		$result .= '<label>Kod</label>';
		$result .= '<textarea name="code">'.str_replace('\n', "\n", @$data['code']).'</textarea>';
		$result .= '<button type="submit" name="save">Zapisz</button>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
        $result .= '</form>';
        return $result;
	}
	
	function changeSigns($text) {
		setlocale(LC_ALL, 'pl_PL');
        $text = str_replace(' ', '_', $text);
        $text = iconv('utf-8', 'ascii//translit', $text);
        $text = preg_replace('#[^a-z\_]#si', '', $text);
        return strtolower(str_replace('\'', '', $text));
    } 

?>
