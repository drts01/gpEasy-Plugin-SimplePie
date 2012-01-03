<?php

require_once('simplepie.inc');

function FeedOut ($feed){
	if ($feed->data): 
		$items = $feed->get_items();
		echo '<p align="center"><span style="background-color:#ffc;">Displaying '; echo $feed->get_item_quantity(); echo ' most recent entries.</span></p>';
		foreach($items as $item):
			echo '<div class="chunk" style="padding:0 5px;">
				<h4 style="margin-bottom:0;"><a href="'; echo $item->get_permalink().'">'.$item->get_title().'</a></h4>
				<div style="font-size:small;">Posted: '.$item->get_date('j M Y').' ';
				if ($author = $item->get_author()) echo 'by '.$author->get_name();
			echo '</div>'.
				$item->get_content();
			echo '<p>';
				if ($item->get_categories()){
					$comma = false; //Control to prevent comma on last 'category'
					echo '<p><span style="font-weight:bold;">TAGS:</span> ';
					foreach ($item->get_categories() as $category){
						if ($rpt) echo ', '; else $comma = true; //add comma but not on last 'category'
						echo $category->get_label();
					}
					echo '</p>';
				}
			if ($enclosure = $item->get_enclosure(0))
				echo '<p><a href="' . $enclosure->get_link() . '" class="download"><img src="./for_the_demo/mini_podcast.png" alt="Podcast" title="Download the Podcast" border="0" /></a></p>';
			echo '</div>';
		endforeach;
	endif;
}