<?php

echo '<p>['.anchor('topic/'.$forum_id, lang('New topic')).']</p>';

$pages = $this->pagination->create_links();
$pr = '';
if ($pages){
  $pr .= '<tr>';
  $pr .= '<th>';
  $pr .= lang('Pages').': '.$pages;
  $pr .= '</th>';
  $pr .= '<th style="width:150px;">&nbsp;</th>';
  $pr .= '</tr>';
}

if ($topics){
  echo '<table class="tbl">';
  echo $pr;
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
    echo '<td class="ar">';
      echo $row['updated']?date('d.m.Y H:i', mysql_to_unix($row['updated'])):date('d.m.Y H:i', mysql_to_unix($row['created']));
    echo '</td>';
    echo '</tr>';
  }
  echo $pr;
  echo '</table>';
}

?>
