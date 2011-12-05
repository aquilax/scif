<script type="text/javascript">
function rsz(elem, max) {
  if (elem == undefined || elem == null) return false;
  if (max == undefined) max = 320;
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
      echo '<div itemscope="itemscope" itemtype="http://schema.org/Article" class="topic">';
        echo '<h3 itemprop="name" id="p'.$row['id'].'">';
        echo q($row['title']);
        if ($first){
          echo ' <span class="social"><g:plusone size="medium" count="false"></g:plusone></span>';
          $first = FALSE;
        }
        echo '</h3>';
        echo '<div class="topi">';
          echo '<div class="txt" itemprop="articleBody">'.render(q($row['body'])).'</div>';
          echo '<div class="meta">';
            echo '<div class="fr">';
            echo ' <em itemprop="dateCreated">'.date('d-m-Y H:i', mysql_to_unix($row['created'])).'</em>';
            echo ' '.anchor(current_url().'#p'.$row['id'], '#'.$row['id']);
            echo '</div>';
          if ($row['tripcode']){
            echo '[<b itemprop="author">'.$row['tripcode'].'</b>]';
            echo ' ['.anchor('edit/'.$row['forum_id'].'/'.$row['id'], lang('edit'), 'rel="nofollow"').']';
          } else {
            echo '&nbsp;';
          }
          echo '</div>';
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
