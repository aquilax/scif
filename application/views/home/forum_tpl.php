<?php

echo $forum['ename'];

echo anchor('', lang('New topic'));

echo $this->pagination->create_links();

if ($topics){
  echo '<ul>';
  foreach($topics as $row){
    echo '<li>'.anchor('topic/'.$row['id'].'/0/'.slug($row['title']), $row['title']).'</li>';
  }
  echo '</ul>';
}

echo $this->pagination->create_links();

?>
