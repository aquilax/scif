<?php

$pages = $this->pagination->create_links();
$pr = '';
$pr .= '<tr>';
$pr .= '<th>';
if ($pages){
  $pr .= lang('Pages').': '.$pages;
}
$pr .= '</th>';
$pr .= '<th style="width:150px;text-align:right">';
$pr .= '[ '.anchor('topic/'.$forum_id, lang('New topic'), 'rel="nofollow"').' ]';
$pr .= '</th>';
$pr .= '</tr>';

echo '<table class="tbl">';
echo $pr;
if ($topics){
  $i = 1;
  foreach($topics as $row){
    if ($i++ % 2 == 0){
      echo '<tr>';
    } else {
      echo '<tr class="e">';
    }
    echo '<td>';
      echo anchor('topic/'.$row['forum_id'].'/'.$row['id'].'/'.slug($row['title']), $row['title']);
    echo '</td>';
    $date = $row['updated']?$row['updated']:$row['created'];
    echo topicDate($date);
    echo '</tr>';
  }
} else {
  echo '<tr class="e">';
  echo '<td colspan="2">'.sprintf(lang('This forum is still empty. Please %s something.'), anchor('topic/'.$forum_id, lang('write'))).'</td>';
  echo '</tr>';
}
echo $pr;
echo '</table>';


?>
