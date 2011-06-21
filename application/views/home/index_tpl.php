<?php
  if ($forums){
    echo '<ul>';
    foreach($forums as $row){
      echo '<li>';
        echo anchor('forum/'.$row['id'].'/0/'.slug($row['title']), $row['title']);
      echo '</li>';
    }
    echo '</ul>';
  }
?>
