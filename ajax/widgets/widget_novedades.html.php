<?php require_once dirname(__FILE__) . '/../../_ruta.php'; ?>

<?php 

?>

<style>

</style>

<?php
/*
$context = [
    'http' => [
        'method' => 'GET',
        'header' => "custom-header: custom-value\r\n" .
            "custom-header-two: custom-value-2\r\n",
        'content' => $data
    ]
];

$context = stream_context_create($context);
$result = file_get_contents('https://enpuntocontrol.com/blog/feed', false);
*/



    $result = file_get_contents('https://enpuntocontrol.com/es/blog/feed', false);
    $rss = new DOMDocument();
    //$rss->load('https://www.tekbox.com.ar/blog/feed');
    $rss->LoadXML($result);
    $feed = array();
    foreach ($rss->getElementsByTagName('item') as $node) {
      $item = array ( 
        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
        'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
        'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
        );
      array_push($feed, $item);
    }
    $limit = 3;
		
    if($limit>count($feed))$limit=count($feed);
		
    for($x=0;$x<$limit;$x++) {
      $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
      $link = $feed[$x]['link'];  
      $description = $feed[$x]['desc'];
      $date = date('l F d, Y', strtotime($feed[$x]['date']));
      echo '<blockquote class="pull-left" style="margin-bottom: 10px;">';
      echo '<p>'.$title.'</p>';
      echo '<small>'.$description.'</small>';
      echo '</blockquote>';
      //echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
      //echo '<small><em>Posted on '.$date.'</em></small></p>';
      //echo '<p>'.$description.'</p>';
    }
    
?>


  


<script type="text/javascript">
	
	
	
	
	
</script>


