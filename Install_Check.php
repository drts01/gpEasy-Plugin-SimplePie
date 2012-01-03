<?php
defined('is_running') or die('Not an entry point...');
 
function Install_Check(){

	// Same checks as sp_compatibility_test.php
	$php_ok = (function_exists('version_compare') && version_compare(phpversion(), '4.3.0', '>='));
	$pcre_ok = extension_loaded('pcre');
	$curl_ok = function_exists('curl_exec');
	$zlib_ok = extension_loaded('zlib');
	$mbstring_ok = extension_loaded('mbstring');
	$iconv_ok = extension_loaded('iconv');
	if (extension_loaded('xmlreader'))	{
		$xml_ok = true;
	}
	elseif (extension_loaded('xml')){
		$parser_check = xml_parser_create();
		xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
		xml_parser_free($parser_check);
		$xml_ok = isset($values[0]['value']);
	}
	else{
		$xml_ok = false;
	}
	//END

	echo '<h3>Required:</h3><ul>';
		echo  '<li><strong>PHP:</strong> ';	if(!$php_ok) echo '<span style="color:red">';	echo phpversion().' '; echo ($php_ok)? '&gt;=' : '&lt;</span>'; echo ' 4.3.0</li>';
		echo '<li><strong>XML:</strong> '; echo ($xml_ok)? 'XML Parsing Supported' : '<span style="color:red">No XML Parsing Support</span>'; echo '</li>';
		echo '<li><strong>PCRE:</strong> '; echo ($pcre_ok)? 'Perl-Compatible Regular Expressions Library Installed' : '<span style="color:red">Perl-Compatible Regular Expressions Library Not Installed</span>'; echo '</li>';
	echo '</ul><h3>Optional:</h3><ul>';
		echo '<li><strong>cURL:</strong> '; echo ($curl_ok)? 'Protocol Library Installed' : 'Protocol Library <span style="text-decoration:underline;text-color:red;">Not</span> Available, Using <code>fsockopen()</code> Instead'; echo'.</li>';
		echo '<li><strong>Zlib:</strong> GZIP-encoding '; if(!$zlib_ok){echo '<span style="text-decoration:underline;text-color:red;">Not</span> ';} echo 'Supported</li>';
		echo '</ul><h4>Non-English Support:</h4>';
		echo '<ul>';
			echo '<li><strong>mbstring:</strong> Extention '; if (!$mbstring_ok){echo '<span style="text-decoration:underline;text-color:red;">Not</span> ';} echo'Installed</li>' ;
			echo '<li><strong>iconv:</strong>  Library '; if(!$iconv_ok){echo '<span style="text-decoration:underline;text-color:red;">Not</span> ';} echo 'Installed</li>'.
		'</ul>';
			echo '<ul style="list-style-type:none;"><li>';
				if ($mbstring_ok && $iconv_ok) echo 'Extend Character Set Enabled';
				elseif ($mbstring_ok || $iconv_ok && !($mbstring_ok && $iconv_ok)) echo 'Partial Support<br /><span style="font-size:small;">Check The <a href="http://simplepie.org/wiki/faq/supported_character_encodings">Supported Character Encodings</a></span>';
				elseif (!$mbstring_ok && !$iconv_ok)	echo 'Extended Character Set <span style="text-decoration:underline;text-color:red;">Not</span> Supported'.
			'</li></ul>';

	return ($php_ok && $pcre_ok && $xml_ok)? true : false;
}
