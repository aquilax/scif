<?php
  if ($forums){
    foreach ($forums as $group_name => $forums_list){
      if ($group_name) {
        echo '<h2>'.$group_name.'</h2>';
      }
      echo '<table class="tbl">';
      echo '<tr>';
        echo '<th>'.lang('Forums').'</th>';
        echo '<th style="width:50px;text-align:right">'.lang('Topics').'</th>';
        echo '<th style="width:150px;text-align:right"></th>';
      echo '</tr>';
      $i = 1;
      foreach($forums_list as $row){
        if ($i++ % 2 == 0){
          echo '<tr>';
        } else {
          echo '<tr class="e">';
        }
        echo '<td>';
          echo anchor('forum/'.$row['id'].'/0/'.slug($row['title']), $row['title'], 'class="b title"');
          if ($row['body']){
            echo '<br /><em style="margin:.2em 0 0 2em">'.$row['body'].'</em>';
          }
        echo '<td class="ar">'.$row['topics'].'</td>';
        echo '</td>';
        echo topicDate($row['updated']);
        echo '</tr>';
      }
      echo '</table>';
    }
  }

  if ($topics){
    echo '<table class="tbl">';
    echo '<tr><th>';
    echo lang('Latest topics');
    echo '</th>';
    echo '<th>'.lang('Forum').'</th>';
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
      echo '<td class="b">';
        echo anchor('forum/'.$row['fid'].'/0/'.slug($row['fname']), $row['fname']);
      echo '</td>';
      echo topicDate($row['updated']);
      echo '</tr>';
    }
    echo '</table>';
  }
?>
