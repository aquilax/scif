<?php
  if ($forums){
    echo '<table class="tbl">';
    echo '<tr><th>';
    echo lang('Forums');
    echo '</th></tr>';
    $i = 1;
    foreach($forums as $row){
      if ($i++ % 2 == 0){
        echo '<tr>';
      } else {
        echo '<tr class="e">';
      }
      echo '<td>';
        echo anchor('forum/'.$row['id'].'/0/'.slug($row['title']), $row['title']);
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }

  if ($topics){
    echo '<table class="tbl">';
    echo '<tr><th>';
    echo lang('Latest topics');
    echo '</th>';
    echo '<th style="width:150px;text-align:right">&nbsp;';
    echo '</tr>';
    $i = 1;
    foreach($topics as $row){
      if ($i++ % 2 == 0){
        echo '<tr>';
      } else {
        echo '<tr class="e">';
      }
      echo '<td>';
        $link = $row['pid']?$row['pid'].'#'.$row['id']:$row['id'].'/'.slug($row['title']);
        echo anchor('topic/'.$row['forum_id'].'/'.$link, $row['title']);
      echo '</td>';
      echo topicDate(mysql_to_unix($row['updated']));
      echo '</tr>';
    }
    echo '</table>';
  }
?>
