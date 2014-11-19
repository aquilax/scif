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
          echo '<div class="txt" itemprop="articleBody">'.render($row['body']).'</div>';
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
// Find all the YouTube video embedded on a page
var videos = document.getElementsByClassName("youtube"); 
 
for (var i=0; i<videos.length; i++) {
  
  var youtube = videos[i];
  var videoId = youtube.getAttribute('data-video');

  // Attach an onclick event to the YouTube Thumbnail
  youtube.onclick = function() {
 
    // Create an iFrame with autoplay set to true
    var iframe = document.createElement("iframe");
    iframe.setAttribute("src",
          "https://www.youtube.com/embed/" + videoId
        + "?autoplay=1&autohide=1&border=0&wmode=opaque&enablejsapi=1"); 
    
    // The height and width of the iFrame should be the same as parent
    iframe.className = 'video_frame' 
    // Replace the YouTube thumbnail with YouTube HTML5 Player
    this.parentNode.replaceChild(iframe, this);
 
  }; 
}
</script>
