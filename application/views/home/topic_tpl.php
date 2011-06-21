<script type="text/javascript">
function rsz(elem, max) {
  if (elem == undefined || elem == null) return false;
  if (max == undefined) max = 100;
  if (elem.width > elem.height) {
    if (elem.width > max) elem.width = max;
  } else {
    if (elem.height > max) elem.height = max;
  }
}
function tgl(elem, max) {
  if (elem == undefined || elem == null) return false;
  if (elem.alt != 1) {
    elem.removeAttribute('width');
    elem.removeAttribute('height');
    elem.alt = 1;
  } else {
    elem.removeAttribute('alt');
    rsz(elem, max);
  }
}
</script>
<?php
  foreach($posts as $row){
    echo '<h3 id="'.$row['id'].'">'.q($row['title']).'</h3>';
    echo '<p>';
    if ($row['tripcode']){
      echo '[<b>'.$row['tripcode'].'</b>]';
      echo ' ['.anchor('edit/'.$row['forum_id'].'/'.$row['id'], lang('редакция'), 'rel="nofollow"').']';
    }
    echo ' <em>'.date('d-m-Y H:i', mysql_to_unix($row['created'])).'</em>';
    echo ' '.anchor(current_url().'#'.$row['id'], '#'.$row['id']);
    echo '</p>';
    echo render(q($row['body']));
    echo '<hr />';
  }
  
  if($posts){
    $ptitle = 'Re:'.$posts[0]['title']; 
  } else {
    $ptitle = '';  
  }

  echo '<div id="post">';
  echo validation_errors();
  echo form_open(current_url().'#post');
  echo '<div id="namef">0ставете това поле празно <input type="text" name="name" value="" id="namef" /></div>'; 
  echo '<table>';
  echo '<tr>';
  echo '<td colspan="2">';
  echo lang('Заглавие', 'title').' <em title="'.lang('Задължително').'">*</em><br/>';
  echo form_input('title', set_value('title', $ptitle), 'id="title" size="60"').'<br/>';
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td colspan="2">';
  echo form_textarea(array('name' => 'body', 'value' => set_value('body'), 'cols'=>'60', 'rows'=>'10'));
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>За да вмъкнете изображение, напишете URL с <b>i</b> отпред <b>ihttp://</b></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo lang('Парола (по желание за трипкод)', 'password').'<br />';
  echo form_password('password', '', 'size="60" id="password"');
  echo '</td>';
  echo '<td valign="bottom" width="100px">';
  echo form_submit('post', lang('Публикувай'), 'onclick="this.disabled=true;this.form.submit()"');
  echo '</td>';
  echo '</table>';
  echo form_close();
  echo '</div>';
?>

