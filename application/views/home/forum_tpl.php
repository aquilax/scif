<?php

echo '<p>['.anchor('topic/'.$forum_id, lang('New topic')).']</p>';

echo $this->pagination->create_links();

if ($topics){
  echo '<ul>';
  foreach($topics as $row){
    echo '<li>'.anchor('topic/'.$row['forum_id'].'/'.$row['id'].'/'.slug($row['title']), $row['title']).'</li>';
  }
  echo '</ul>';
}

echo $this->pagination->create_links();

?>
