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
?>
