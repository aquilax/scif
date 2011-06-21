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
  if ($posts){
    foreach($posts as $row){
      echo '<h3 id="'.$row['id'].'">'.q($row['title']).'</h3>';
      echo '<p>';
      if ($row['tripcode']){
        echo '[<b>'.$row['tripcode'].'</b>]';
        echo ' ['.anchor('edit/'.$row['forum_id'].'/'.$row['id'], lang('edit'), 'rel="nofollow"').']';
      }
      echo ' <em>'.date('d-m-Y H:i', mysql_to_unix($row['created'])).'</em>';
      echo ' '.anchor(current_url().'#'.$row['id'], '#'.$row['id']);
      echo '</p>';
      echo render(q($row['body']));
      echo '<hr />';
    }
  }

  $this->load->view('partials/post_form_tpl');

?>

