<?php
  echo '<div id="post" class="topic">';
  echo '<h3>'.$form_title.'</h3>';
  echo validation_errors();
  echo form_open(current_url().'#post');
  echo '<table>';
  echo '<tr>';
  echo '<td colspan="2">';
  echo lang('Title', 'title').' <em title="'.lang('Mandatory').'">*</em><br/>';
  echo form_input('title', set_value('title', $post['title']), 'id="title" size="60"').'<br/>';
  echo '</td>';
  echo '</tr>';
?>
  <tr><td colspan="2">
    <button type="button" tabindex="-1" onclick="document.getElementById('imageUpload').click();return false;"><?php echo lang('Image'); ?></button>
    <button type="button" tabindex="-1" onclick="quote();return false;"><?php echo lang('Quote'); ?></button>
    <input id="imageUpload" style="visibility: collapse; width: 0px;" type="file" onchange="upload(this.files[0])">  
  </td></tr> 
<?php
  echo '<tr>';
  echo '<td colspan="2">';
  echo form_textarea(array('name' => 'body', 'value' => set_value('body', $post['body']), 'cols'=>'60', 'rows'=>'10', 'id'=> 'textarea'));
  echo '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td colspan="2">'.lang('To add picture type the url with <b>i</b> in front <b>ihttp://</b>').'</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>';
  echo lang('Password', 'password').'<br />';
  echo form_password('password', '', 'size="60" id="password"');
  echo '</td>';
  echo '<td style="vertical-align:bottom; width:100px">';
  echo form_submit('post', lang($button_title), 'onclick="this.disabled=true;this.form.submit()"');
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  echo '<div id="namef">'.lang('Leave thiz field empty').'<input type="text" name="name" value="" id="namefa" /></div>'; 
  echo form_close();
  echo '</div>';
?>
<script>
    // https://hacks.mozilla.org/2011/03/the-shortest-image-uploader-ever/
    function upload(file) {
        /* Is the file an image? */
        if (!file || !file.type.match(/image.*/)) return;
    
        /* Lets build a FormData object*/
        var fd = new FormData(); // I wrote about it: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
        fd.append("image", file); // Append the file
        var xhr = new XMLHttpRequest(); // Create the XHR (Cross-Domain XHR FTW!!!) Thank you sooooo much imgur.com
        xhr.open("POST", "https://api.imgur.com/3/upload.json"); // Boooom!
        xhr.setRequestHeader('Authorization', 'Client-ID c2e15b62bf762a8');
        xhr.onload = function() {
            // Big win!
            var data = JSON.parse(xhr.responseText),
                textarea = document.getElementById('textarea'),
                texta = textarea.value.split("\n");
            if (data.data && data.data.link) {
                texta.push('i' + data.data.link);
                textarea.value = texta.join("\n");
            }
            //document.querySelector("#link").href = JSON.parse(xhr.responseText).upload.links.imgur_page;
        }
        /* And now, we send the formdata */
        xhr.send(fd);
    }
    function quote() {
        var textComponent = document.getElementById('textarea'),
            text = textComponent.value,
            startPos = textComponent.selectionStart,
            endPos = textComponent.selectionEnd,
            selLenght,
            segment,
            newSegment = [];
        if (startPos != undefined) {
            selLength = endPos - startPos;
            segment = text.substr(startPos, selLength);
            segment.split("\n").forEach(function(row) {
                newSegment.push("> " + row);
            });
            textComponent.value = [
                text.substr(0, startPos),
                newSegment.join("\n"),
                text.substr(endPos)
            ].join("\n");
        }
    }
</script> 
