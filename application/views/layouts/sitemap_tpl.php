<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>
<urlset
  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"       
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php 
   function row($url, $lastmod){
     printf('<url><loc>%s</loc><lastmod>'.$lastmod.'</lastmod></url>', $url);
   } 
   foreach ($all->result_array() as $link){
     row(site_url('topic/'.$link['forum_id'].'/'.$link['id'].'/'.slug($link['title'])), date('Y-m-d', mysql_to_unix($link['updated'])));
   }
?>
</urlset>

