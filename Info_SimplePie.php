<?php
defined('is_running') or die('Not an entry point...');

require_once('simplepie.inc');

class Info_SimplePie{
	function Info_SimplePie(){
		echo '<h2>SimplePie Infomation</h2>';

		echo '<p>';
		echo 'This addon is using '.SIMPLEPIE_LINKBACK." ".SIMPLEPIE_VERSION.' build '.SIMPLEPIE_BUILD;
		echo '</p>';

		echo '<p>';
		echo 'Try the '.common::Link('Special_SimplePie','Special SimplePie').' page.';
		echo '</p>';

	}
}


