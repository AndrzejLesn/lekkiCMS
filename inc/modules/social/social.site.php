<?php
defined('IN_LCMS') or exit('Access denied!');
$core->replace('{{contact.cfg}}', social());
$core->append(socialcss(), 'head'); 
function social() {
		global $core, $db, $lang;
		$result = NULL;
        $query = $db->select('social_cfg');
		
foreach($query as $record) {
$icon = $record['iconpack'];
$size = $record['size'];
                             }	
global $core, $db, $lang;
$result = NULL;
$query2 = $db->select('social');		
$result ='<div id="socialdiv">';
$result .='<div id="socialdivh3">Skontaktuj się z nami</div>';
 $result .='<div id="socialcnt">';
  foreach($query2 as $record3)
    {
$result .= '<span class="socialadr">Telefon : '.$record3['tel'].'</span>';
$result .= '<span class="socialadr">Ulica : '.$record3['adr'].'</span>';
$result .= '<span class="socialadr">Miasto : '.$record3['adr1'].' Kod : '.$record3['adr2'].'</span>';
}
$result .='</div>';
$result .= '<div id="socialitems">';
foreach($query2 as $record3){
if($record3['EM'] == '#') {} else{
$result .= '<div id="socialitem"><a href="mailto:'.$record3['EM'].'"  target="_blank"><img src="./inc/modules/social/media/'.$icon.'/email.png" height="'.$size.'px"</a></div>';
}
if($record3['FB'] == '#') {} else{
$result .= '<div id="socialitem"><a href="'.$record3['FB'].'" target="_blank"><img src="./inc/modules/social/media/'.$icon.'/FB.png" height="'.$size.'px"</a></div>';
}
if($record3['TW'] == '#') {} else{
$result .= '<div id="socialitem"><a href="'.$record3['TW'].'"  target="_blank"><img src="./inc/modules/social/media/'.$icon.'/TW.png" height="'.$size.'px"</a></div>';
}
if($record3['G+'] == '#') {} else{
$result .= '<div id="socialitem"><a href="'.$record3['G+'].'"  target="_blank"><img src="./inc/modules/social/media/'.$icon.'/G+.png" height="'.$size.'px"</a></div>';
}
if($record3['YT'] == '#') {} else{
$result .= '<div id="socialitem"><a href="'.$record3['YT'].'"  target="_blank"><img src="./inc/modules/social/media/'.$icon.'/YT.png" height="'.$size.'px"</a></div>';
}}
$result .= '</div>';
$result .= '</div>';
return $result;
}
function socialcss() {
 $head = '<link href="http://fonts.googleapis.com/css?family=Clicker+Script&subset=latin,latin-ext" rel="stylesheet" type="text/css"><style type="text/css">
/* <![CDATA[ */
@import url('.MODULES.'/social/social.css);
/* ]]> */
</style>';
return $head;
}
?>
