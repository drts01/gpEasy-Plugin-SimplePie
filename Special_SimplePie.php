<?php
defined('is_running') or die('Not an entry point...');

// require_once('simplepie.inc'); //Included in FeedOut.php
require_once('FeedOut.php');

class Special_SimplePie{
	var $start;
	var $feed;

	function Special_SimplePie(){
		$feed = new SimplePie();
		$start = self::microtime_float();
		
		// Parse it
		if (!empty($_GET['feed']))
		{
			if (get_magic_quotes_gpc())
			{
				$_GET['feed'] = stripslashes($_GET['feed']);
			}
			$feed->set_feed_url($_GET['feed']);
			$feed->init();
		}
		$feed->handle_content_type();

		echo '<h1>'; echo (empty($_GET['feed'])) ? 'SimplePie' : 'SimplePie: ' . $feed->get_title(); echo '</h1>';
		echo '<form action="" method="get" name="sp_form" id="sp_form" style="text-align:center;"><p>
					<input type="text" name="feed" value="'; echo ($feed->subscribe_url()) ? htmlspecialchars($feed->subscribe_url()) : 'http://'; echo '" class="text" id="feed_input" />&nbsp;<input type="submit" value="Read" class="button" />
				</p></form>
			<div id="sp_results">';
		FeedOut($feed);
		echo '</div>';
	}
	
	function microtime_float(){
		if (version_compare(phpversion(), '5.0.0', '>=')){
			return microtime(true);
		}
		else{
			list($usec, $sec) = explode(' ', microtime());
			return ((float) $usec + (float) $sec);
		}
	}
}