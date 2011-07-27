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
    $first = TRUE;
    foreach($posts as $row){
      echo '<div class="topic">';
        echo '<h3 id="'.$row['id'].'">';
        echo q($row['title']);
        if ($first){
          echo ' <div class="social"><g:plusone size="medium" count="false"></g:plusone></div>';
          $first = FALSE;
        }
        echo '</h3>';
        echo '<div class="topi">';
          echo '<div class="meta">';
          if ($row['tripcode']){
            echo '[<b>'.$row['tripcode'].'</b>]';
            echo ' ['.anchor('edit/'.$row['forum_id'].'/'.$row['id'], lang('edit'), 'rel="nofollow"').']';
          }
          echo ' <em>'.date('d-m-Y H:i', mysql_to_unix($row['created'])).'</em>';
          echo ' '.anchor(current_url().'#'.$row['id'], '#'.$row['id']);
          echo '</div>';
          echo render(q($row['body']));
        echo '</div>';
      echo '</div>';
    }
  }

  $this->load->view('partials/post_form_tpl');
?>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
