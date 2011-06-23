<?php
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
  <channel>
    <title><?php echo $title; ?></title>
    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>
    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <atom:link href="<?php echo current_url()?>" rel="self" type="application/rss+xml" />
<?php foreach($posts as $entry): ?>
    <item>
<?php $url = $entry['pid']?site_url('fm/nf/'.$entry['forum_id'].'/'.$entry['pid'].'#'.$entry['id']):site_url('fm/nf/'.$entry['forum_id'].'/'.$entry['id']); ?>
      <title><?php echo xml_convert($entry['title'])?></title>
      <link><?php echo $url?></link>
      <guid><?php echo $url?></guid>
      <description><![CDATA[<?php echo render($entry['body'])?>]]></description>
      <pubDate><?php echo date ('r', mysql_to_unix($entry['created']));?></pubDate>
    </item>
<?php endforeach; ?>
  </channel>
</rss>

