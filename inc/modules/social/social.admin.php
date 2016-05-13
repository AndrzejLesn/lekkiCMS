<?php
defined('IN_LCMS') or exit('Access denied!');
function social_pages()
{
    $pages[] = array(
        'func' => 'social_show',
        'title' => 'Lista'
    );
    $pages[] = array(
        'func' => 'social_cfg',
        'title' => 'CFG'
    );
    return $pages;
}
function social_show()
{
    global $lang, $db, $core;
    $result = NULL;
    if (isset($_GET['q']) && isset($_GET['id'])) {
        $condtion = array('id' => $_GET['id']);
        $query  = $db->select('social', $condtion);
        if ($query) {
            if ($_GET['q'] == 'edit') {
                if (isset($_POST['save'])) {
                    if (!empty($_POST['FB']) && !empty($_POST['TW']) && !empty($_POST['YT']) && !empty($_POST['G+']) && !empty($_POST['EM'])&& !empty($_POST['tel'])&& !empty($_POST['adr'])&& !empty($_POST['adr1'])&& !empty($_POST['adr2'])) {
                        $updateRecord = array($_POST['id'], $_POST['FB'], $_POST['TW'], $_POST['YT'], $_POST['G+'], $_POST['EM'], $_POST['tel'], $_POST['adr'], $_POST['adr1'], $_POST['adr2']);
                        if ($db->update('social', $condtion, $updateRecord)) {
                            $core->notify('Pozycja została dodana', 1);
                        }
                    }
                } else {
                    $condtion = array( 'id' => $_GET['id']);
                    $query    = $db->select('social', $condtion);
                    $record   = $query[0];
                    $result .= social_form($record);
                }
            }
            if ($_GET['q'] == 'del') {
                if ($db->delete('social', $condtion)) {
                    $core->notify('Pozycja została usunięta', 1);
                }
            }
        } else
            $core->notify("The record doesn't exist", 2);
    }
    $query = $db->select('social');
    $result .= '<table> <thead>';
    $result .= '<tr> <td>Nazwa</td> <td> Adres </td> </tr>';
    $result .= '</thead> <tbody>';
    foreach ($query as $record) {
        $result .= '<tr><td>Facebook</td> <td> ' . $record['FB'] . '</td></tr><tr><td>Twitter</td> <td> ' . $record['TW'] . '</td></tr><tr><td>Youtube</td> <td> ' . $record['YT'] . '</td></tr><tr><td>Google+</td> <td> ' . $record['G+'] . '</td> </tr><tr><td>Email</td> <td> ' . $record['EM'] . '</td> </tr><tr><td>Adres</td> <td> ' . $record['tel'] . '<br>' . $record['adr'] . '<br>' . $record['adr1'] . '<br>' . $record['adr2'] . '</td> </tr><tr><td>Opcje</td> <td><a href="?go=social&action=social_show&q=edit&id=' . $record['id'] . '" class="icon">Z</a> </td> </tr>';
    }
    $result .= '</tbody> </table>';
    return $result;
}

function social_form($data = array())
{
    $result = '<form method="post"  name="social" enctype="multipart/form-data">';
    $result .= '<label>Facebook</label>';
    $result .= '<input type="text" name="FB" value="'.$data['FB'].'">';
    $result .= '<label>Twitter</label>';
    $result .= '<input type="text" name="TW" value="'.$data['TW'].'">';
    $result .= '<label>Youtube</label>';
    $result .= '<input type="text" name="YT" value="'.$data['YT'].'">';
    $result .= '<label>Google+</label>';
    $result .= '<input type="text" name="G+" value="'.$data['G+'].'">';
    $result .= '<label>Email</label>';
    $result .= '<input type="text" name="EM" value="'.$data['EM'].'">';
	  $result .= '<label>Telefon</label>';
    $result .= '<input type="text" name="tel" value="'.$data['tel'].'">';
	  $result .= '<label>Ulica</label>';
    $result .= '<input type="text" name="adr" value="'.$data['adr'].'">';
	  $result .= '<label>Miasto</label>';
    $result .= '<input type="text" name="adr1" value="'.$data['adr1'].'">';
	  $result .= '<label>Kod pocztowy</label>';
    $result .= '<input type="text" name="adr2" value="'.$data['adr2'].'">';
    $result .= '<button type="submit" name="save">Zapisz</button>';
    if ($data)
        $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
    $result .= '</form><br>';
    return $result;
}

function social_cfg()
{
  global $lang, $db, $core;
    $result = NULL;
    if (isset($_GET['q']) && isset($_GET['id'])) {
        $condtion = array('id' => $_GET['id']);
        $query = $db->select('social_cfg', $condtion);
        if ($query) {
            if ($_GET['q'] == 'edit') {
                if (isset($_POST['save'])) {
                    if (!empty($_POST['size']) && !empty($_POST['iconpack']) ) {
                        $updateRecord = array( $_POST['id'], $_POST['iconpack'], $_POST['size']);
                        if ($db->update('social_cfg', $condtion, $updateRecord)) {
                            $core->notify('Pozycja została dodana', 1);
                        }
                    }
                } else {
                    $condtion = array('id' => $_GET['id']);
                    $query    = $db->select('social_cfg', $condtion);
                    $record   = $query[0];
                    $result .= social_cfg_form($record);
                }
            }
            if ($_GET['q'] == 'del') {
                if ($db->delete('social_cfg', $condtion)) {
                    $core->notify('Pozycja została usunięta', 1);
                }
            }
        } else
            $core->notify("The record doesn't exist", 2);
    }
    $query = $db->select('social_cfg');
    $result .= '<table> <thead>';
    $result .= '<tr> <td>Nazwa</td> <td> Wartość </td> <td>Opcje</td> </tr>';
    $result .= '</thead> <tbody>';
    foreach ($query as $record) {
        $result .= '<tr><td>IconPack</td> <td> ' . $record['iconpack'] . '</td></tr><tr><td>Rozmiar</td> <td> ' . $record['size'] . ' px</td></tr><td><a href="?go=social&action=social_cfg&q=edit&id=' . $record['id'] . '" class="icon">Z</a> </td> </tr>';
    }
    $result .= '</tbody> </table>';
    return $result;
}

function social_cfg_form($data = array())
{
$dir = '../inc/modules/social/media';
$scan = scandir($dir);

    $result  = '<form method="post"  name="upload" enctype="multipart/form-data">';
    $result .= '<label>Rozmiar ikon</label>';
    $result .= '<input type ="text" name="size" value="' . $data['size'] . '">';
   $result .='<label>Iconpack</label>';
   $result .='<select name="iconpack">';
     global $lang, $db, $core;
   $condtion = array('id'=>'1');
			$q = $db->select('social_cfg', $condtion);
			foreach($q as $s) {
  $sel=$s['iconpack'];
  }
  if ($fl == $sel ) $selk = 'selected' ; 
foreach($scan as $data['iconpack']) {
if(is_dir($dir.'/'.$data['iconpack'])) {
if(($data['iconpack'] != '.') && ($data['iconpack'] != '..')){
$fl = $data['iconpack'];
$result .='<option '.$selk.' value ="'.$data['iconpack'].'">'.$fl.' / ' .$data['iconpack']. '</option>';
}
}
}
$result .='</select>';
    $result .= '<button type="submit" name="save">Zapisz</button>';
    if ($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
    $result .= '</form><br>';
	foreach($scan as $f) {
if(is_dir($dir.'/'.$f)) {
if(($f != '.') && ($f != '..')){
$result .='<img src="'.$dir.'/'.$f.'/TW.png" height="' . $data['size'] . 'px"><img src="'.$dir.'/'.$f.'/FB.png" height="' . $data['size'] . 'px"><img src="'.$dir.'/'.$f.'/G+.png" height="' . $data['size'] . 'px"> Szablon : ' .$f.'<br>';
}
}
}
    return $result;
}

