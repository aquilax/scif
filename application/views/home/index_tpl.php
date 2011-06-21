<?php
  echo $title;
  if ($forums){
    echo '<ul>';
    foreach($forums as $row){
      echo '<li>';
        echo anchor('forum/'.$row['id'].'/0/'.slug($row['ename']), $row['ename']);
      echo '</li>';
    }
    echo '</ul>';
  }
?>
