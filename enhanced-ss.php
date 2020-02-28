<?php
/*
Plugin Name: Simple Spoiler Enhanced
Description: Add show/hide text enclosed within <spoiler></spoiler> or [spoiler][/spoiler] with a link. Original idea by <a href="http://www.waikay.net">Leong Wai Kay</a>.
Version: 1.0.0
Author: Marcelo Prado
Author URI: https://github.com/lennonprado

Features:
  Displays a simple link instead of a button.
  Less code per tag use.
  Supports multiple spoiler tags on the same page.

Installation: Place this file in your plugins directory and activate it in your admin panel.
Usuage: Enclose spoiler text between <spoiler> </spoiler> or or [spoiler][/spoiler] in either blog entries or comments.

*/

// add filter hook
add_filter('the_content', 'spoilerVersion1', 2);
add_filter('the_content', 'spoilerVersion2', 2);
add_filter('comment_text', 'spoilerVersion1', 4);
add_filter('comment_text', 'spoilerVersion2', 4);

function spoilerVersion1($content)
{
  srand((double) microtime()*100000);
  return preg_replace_callback(
    "%<spoiler.*(?:'([^']*)')?\s*(?:'([^']*)')?\s*>(.*)</spoiler>%isU",
    "spoiler_callback",
    $content);
}

function spoilerVersion2($content)
{
  srand((double) microtime()*100000);
  return preg_replace_callback(
    "%\[spoiler.*(?:/([^'/]*)/)?\s*(?:/([^'/]*)/)?\s*\](.*)\[/spoiler\]%isU",
    "spoiler_callback",
    $content);
}

function spoiler_callback($m)
{
  $rand = "SID".rand();
  $contenido = "<h2><a href='javascript:void(null);' onclick='toggle_article(\"$rand\");'><i class='fa fa-book' aria-hidden='true'></i> <span class='txt-caption'>Leer</span></a></h2>";
  $contenido .="<div id='$rand' style='display:none;'>".$m[3]."</div>";
  return $contenido;
}

function add_spoiler_header($text)
{
echo "
	<script type='text/javascript' language='Javascript'>
		function toggle_article(id){
			var articulo = 'div#'+id;
			jQuery(articulo).toggle();
		}
	</script>";                                            
  return $text;
}

add_action('wp_head', 'add_spoiler_header');
?>
