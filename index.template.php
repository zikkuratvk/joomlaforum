<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show right to left and the character set for ease of translating.
	echo '<!DOCTYPE html>
<html lang="ru-ru"', $context['right_to_left'] ? ' dir="rtl"' : 'dir="ltr"', '>
<head>';
	echo'
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="', $context['page_title_html_safe'], '">', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '">' : '', '
	<title>', $context['page_title_html_safe'], ' - Форум русской поддержки Joomla!</title>';

	// Please don't index these Mr Robot.
	if (!empty($context['robot_no_index']))
		echo '';

	// Present a canonical url for search engines to prevent duplicate content in their indices.
	if (!empty($context['canonical_url']))
		echo '
	<link rel="canonical" href="', $context['canonical_url'], '">';

	// Show all the relative links, such as help, search, contents, and the like.
	echo '
	<link rel="help" href="', $scripturl, '?action=help">
	<link rel="search" href="', $scripturl, '?action=search">';

	// If RSS feeds are enabled, advertise the presence of one.
	if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
		echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml">';

	// If we're viewing a topic, these should be the previous and next topics, respectively.
	/*if (!empty($context['current_topic']))
		echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev">
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next">';*/

	// If we're in a board, or a topic for that matter, the index will be the board's index.
	if (!empty($context['current_board']))
		echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0">';

	// The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
	echo '
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/bootstrap.css?fin26">
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/font-awesome.min.css?fin26">
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin35">';

	// Some browsers need an extra stylesheet due to bugs/compatibility issues.
	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
		if ($context['browser']['is_' . $cssfix])
			echo '
	<link rel="stylesheet" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css">';

	// RTL languages require an additional stylesheet.
	if ($context['right_to_left'])
		echo '
	<link rel="stylesheet" href="', $settings['theme_url'], '/css/rtl.css">';

	echo '
	<style>
	@media (min-width: 768px) {
		.container {
			width: ' . $settings['forum_width'] . ';
		}
	}';
	if (!empty($settings['redsy_navbar_height']))
	{
	echo'
	.navbar-default {
		height: ' . $settings['redsy_navbar_height'] . ';
	}
	.navbar-default .navbar-nav, .nav-notification {
		margin-top: ' . (($settings['redsy_navbar_height'] - 50) / 2)  . 'px !important;
	}
	.navbar-toggle, .navbar-brand {
		height: ' . $settings['redsy_navbar_height']  . ' !important;
	}
	.navbar-toggle {
		line-height: ' . $settings['redsy_navbar_height']  . ' !important;
	}
	.navbar-brand {
		line-height: ' . ($settings['redsy_navbar_height'] - 30) . 'px !important;
	}
	.navbar-brand .logo {
		max-height: ' . $settings['redsy_navbar_height']  . ' !important;
	}';
	}
	echo '
	</style>';

	// Here comes the JavaScript bits!
	echo '
	<script src="', $settings['theme_url'], '/scripts/jquery.min.js"></script>
	<script src="', $settings['theme_url'], '/scripts/bootstrap.min.js?fin26"></script>
	<script src="', $settings['theme_url'], '/scripts/redsy.js?fin26"></script>
	<script>
	$(document).ready(function(){
		$("input[type=button]").attr("class", "btn btn-default btn-sm");
		$(".button_submit").attr("class", "btn btn-danger btn-sm");
		$("#advanced_search input[type=\'text\'], #search_term_input input[type=\'text\']").removeAttr("size");
		$(".table_grid").addClass("table table-striped");
		$("#profile_success").removeAttr("id").removeClass("windowbg").addClass("alert alert-success");
		$("#profile_error").removeAttr("id").removeClass("windowbg").addClass("alert alert-danger");
	});
	</script>
	<script src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
	<script><!-- // --><![CDATA[
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

	// Output any remaining HTML headers. (from mods, maybe?)
	echo $context['html_headers'];

	echo '
</head>
<body', !empty($settings['redsy_navbar']) ? ' style="padding-top: ' . (!empty($settings['redsy_navbar_height']) ? $settings['redsy_navbar_height'] : '50px') . ';"' :  '' ,'>';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo'
<div id="wrapper">
	<nav class="navbar navbar-default ', !empty($settings['redsy_navbar']) ? 'navbar-fixed-top' :  'navbar-static-top' ,'">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>';

			if(!empty($context['user']['is_logged']))
				echo '
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user-menu">
					<i class="fa fa-user"></i>
				</button>';

			echo '
				<a class="navbar-brand" href="/">Форум поддержки Joomla</a>
			</div>
			<div class="collapse navbar-collapse">
				<button type="button" class="navbar-toggle collapsed collapsemenu" id="upshrink" style="display: none;">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>';
				if(!empty($context['user']['is_logged']))
				{
				echo'
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown first-level">
							<a href="' , $scripturl , '?action=profile" class="dropdown-toggle">
								<img class="avatar img-circle" src="', !empty($context['user']['avatar']['href']) ? $context['user']['avatar']['href'] : $settings['images_url']. '/noavatar.png' ,'" alt="*">
								<span>', $context['user']['name'], '</span> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="' , $scripturl , '?action=profile;area=forumprofile;"><i class="fa fa-gear fa-fw"></i>Настройки профиля</a></li>
								<li><a href="' , $scripturl , '?action=profile;area=account;"><i class="fa fa-wrench fa-fw"></i>Настройки аккаунта</a></li>
								<li><a href="' , $scripturl , '?action=unread;"><i class="fa fa-comment fa-fw"></i>' , $txt['new_posts'] , '</a></li>
								<li><a href="' , $scripturl , '?action=unreadreplies;"><i class="fa fa-comments fa-fw"></i>Новые ответы</a></li>
								<li class="divider"></li>
								<li><a href="' , $scripturl , '?action=logout;sesc=', $context['session_id'], '"><i class="fa fa-sign-out fa-fw"></i>' , $txt['logout'] , '</a></li>
							</ul>
						</li>
					</ul>';
				}
				echo'
				<ul class="nav-notification navbar-right">
					<li class="search-list">
						<div class="search-input-wrapper">
							<div class="search-input">
								<form action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
									<input name="search" type="text" class="form-control input-sm inline-block">
									<a href="#" class="input-icon text-normal">
										<i class="fa fa-search"></i>
									</a>';
									// Search within current topic?
									if (!empty($context['current_topic']))
										echo '
											<input type="hidden" name="topic" value="', $context['current_topic'], '">';
									// If we're on a certain board, limit it to this board ;).
									elseif (!empty($context['current_board']))
										echo '
											<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '">';
									echo '
								</form>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>';

	template_menu();

	// Define the upper_section toggle in JavaScript.
	if(!empty($context['user']['is_logged']))
	echo '
	<div class="collapse navbar-collapse" id="user-menu">
		<ul class="nav navbar-nav" role="menu">
			<li><a href="' , $scripturl , '?action=profile;area=forumprofile;"><i class="fa fa-gear fa-fw"></i>Настройка профиля</a></li>
			<li><a href="' , $scripturl , '?action=profile;area=account;"><i class="fa fa-wrench fa-fw"></i>Профиль</a></li>
			<li><a href="' , $scripturl , '?action=unread;"><i class="fa fa-comment fa-fw"></i>' , $txt['new_posts'] , '</a></li>
			<li><a href="' , $scripturl , '?action=unreadreplies;"><i class="fa fa-comments fa-fw"></i>Новые ответы</a></li>
			<li class="divider"></li>
			<li><a href="' , $scripturl , '?action=logout;sesc=', $context['session_id'], '"><i class="fa fa-sign-out fa-fw"></i>' , $txt['logout'] , '</a></li>
		</ul>
	</div>';
	echo '
		<script><!-- // --><![CDATA[
			var oMainHeaderToggle = new smc_Toggle({
				bToggleEnabled: true,
				bCurrentlyCollapsed: ', empty($options['collapse_header']) ? 'false' : 'true', ',
				aSwappableContainers: [
					\'menu\', \'header\'
				],
				aSwapImages: [
					{
						sId: \'upshrink\',
						srcExpanded: \'\',
						srcCollapsed: \'\',
					}
				],
				oThemeOptions: {
					bUseThemeSettings: ', $context['user']['is_guest'] ? 'false' : 'true', ',
					sOptionName: \'collapse_header\',
					sSessionVar: ', JavaScriptEscape($context['session_var']), ',
					sSessionId: ', JavaScriptEscape($context['session_id']), '
				},
				oCookieOptions: {
					bUseCookie: ', $context['user']['is_guest'] ? 'true' : 'false', ',
					sCookieName: \'upshrink\'
				}
			});
		// ]]></script>';

		echo'
	<header id="header">
		<div class="container">';
			pages_titlesdesc();
			theme_linktree();
		echo'
		</div>
	</header>';



	echo '<div id="context_advert_top" style="margin: 0 auto; padding: 15px 0 0; text-align: center; width: 90%; overflow: hidden">';
        
    	if (time() < strtotime('03.09.2017')) {
	    echo '<a href="https://alex-kurteev.ru/op/go/joomlaforum/p/mainjoomla" target="_blank" title="Основной курс по Joomla"><img src="/sponsors/kurteev_2.jpg" alt="Основной курс по Joomla" /></a>';
	} else {
	    // * Kogda nichego ne pokazivaetsya iz reklami - vivodit` etot blok!
	    echo ' <!-- joomlaforum 1 -->
	        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2531481678919935" data-ad-slot="4050737667" data-ad-format="auto"></ins>
	        <script>
	            (adsbygoogle = window.adsbygoogle || []).push({});
        	</script>';
	}
	
	        //      echo '<a href="https://alex-kurteev.ru/op/go/joomlaforum/p/mainjoomla" target="_blank" title="Основной курс по Joomla"><img src="/sponsors/kurteev_1.jpg" alt="Основной курс по Joomla" /></a>';
	        //      echo '<a href="http://joomladay.ru/" target="_blank" rel="nofollow" title="JoomlaDay 2017 in Moscow"><img style="display: block; margin-left: auto; margin-right: auto; max-width: 100%;" src="http://joomlaforum.ru/sponsors/jd-joomlaforum.png" alt="JoomlaDay 2017 in Moscow" /></a>';
	        
    echo '</div>';

	

	// The main content should go here.
	echo '
	<div class="container"><div id="content_section">
		<div id="main_content_section">';

	// Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;
	
	if (!defined('_SAPE_USER')){
        define('_SAPE_USER', 'f4848f57d06f3f89549ce8829042f78e');
     }
    require_once(realpath($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'));	 
    $o = array();
	$o['charset'] = 'utf-8'; 
    $sape = new SAPE_client($o); 
    unset($o);	
	
	 
	echo $sape->return_block_links();

	echo '
		</div>
	</div></div>';
	


	// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	echo '
	<footer><div class="container">
		<ul class="social">
			<li>&nbsp;</li>';
			if(!empty($settings['facebook_check']))
			echo'
			<li>
				<a href="', !empty($settings['facebook_text']) ? $settings['facebook_text'] : 'http://www.facebook.com ' ,'" title="', $txt['rs_facebook'], '"><i class="fa fa-facebook fa-2x"></i></a>
			</li>';
			if(!empty($settings['twitter_check']))
			echo'
			<li>
				<a href="', !empty($settings['twitter_text']) ? $settings['twitter_text'] : 'http://www.twitter.com' ,'" title="', $txt['rs_twitter'], '"><i class="fa fa-twitter fa-2x"></i></a>
			</li>';
			if(!empty($settings['youtube_check']))
			echo'
			<li>
				<a href="', !empty($settings['youtube_text']) ? $settings['youtube_text'] : 'http://www.youtube.com' ,'" title="', $txt['rs_youtube'], '"><i class="fa fa-youtube fa-2x"></i></a>
			</li>';
			if(!empty($settings['rss_check']))
			echo'
			<li>
				<a href="', !empty($settings['rss_text']) ? $settings['rss_text'] : $scripturl .'?action=.xml;type=rss' ,'" title="', $txt['rs_rss'], '"><i class="fa fa-rss fa-2x"></i></a>
			</li>';
	
			echo'
		</ul>
		<ul class="reset">
			<li>Работает на SMF </li>
			<li>JoomlaForum &copy; 2006-' .date("Y") . '</li>
			<li>Joomlaforum.ru is not affiliated with or endorsed by the Joomla! Project or Open Source Matters.
The Joomla! name and logo is used under a limited license granted by Open Source Matters
the trademark holder in the United States and other countries.</li>

		</ul>


<script>
  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

  ga("create", "UA-5046115-16", "auto");
  ga("send", "pageview");

</script>
		';

	// Show the load time?
	if ($context['show_load_time'])
		echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';
		
		
	echo '
	</div></footer>
	<a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>
</div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
	global $context, $settings, $options, $shown_linktree;

	// If linktree is empty, just return - also allow an override.
	if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
		return;

	echo '
		<ol class="breadcrumb">';

	// Each tree item has a URL and name. Some may have extra_before and extra_after.
	foreach ($context['linktree'] as $link_num => $tree)
	{
		echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

		// Show the link, including a URL if it should have one.
		echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

		echo '
			</li>';
	}
	echo '
		</ol>';

	$shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
	<div id="menu">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<div class="container">
				<div class="row">
					<ul class="nav navbar-nav">';

			foreach ($context['menu_buttons'] as $act => $button)
			{
				echo '
						<li id="button_', $act, '" class="', $button['active_button'] ? 'active ' : '', '', !empty($button['sub_buttons']) ? 'dropdown first-level' : '', '">
							<a ', !empty($button['sub_buttons']) ? 'class="dropdown-toggle"' : '', ' href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
								', $button['title'], '', !empty($button['sub_buttons']) ? ' <span class="caret"></span>' : '' ,'
							</a>';
				if (!empty($button['sub_buttons']))
				{
					echo '
							<ul class="dropdown-menu" role="menu">';

					foreach ($button['sub_buttons'] as $childbutton)
					{
						echo '
								<li>
									<a href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
										<span', isset($childbutton['is_last']) ? ' class="last"' : '', '>', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '</span>
									</a>';
						// 3rd level menus :)
						if (!empty($childbutton['sub_buttons']))
						{
							echo '
									<ul>';

							foreach ($childbutton['sub_buttons'] as $grandchildbutton)
								echo '
										<li>
											<a href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
												<span', isset($grandchildbutton['is_last']) ? ' class="last"' : '', '>', $grandchildbutton['title'], '</span>
											</a>
										</li>';

							echo '
									</ul>';
						}

						echo '
								</li>';
					}
						echo '					
							</ul>';
				}
				echo '
						</li>';
			}

			echo '
						<li class="dropdown first-level" id="faqMenu"><a class="dropdown-toggle" >FAQ <span class="caret"></span></a>
						
							<ul class="dropdown-menu" role="menu">
								<li><a href="/index.php/topic,232213.0.html">FAQ Joomla 3</a></li>
								<li><a href="/index.php/topic,148002.0.html">FAQ Joomla 2.5 (версия не поддерживается)</a></li>
								<li><a href="/index.php/topic,84596.0.html">FAQ Joomla 1.5 (версия не поддерживается)</a></li>
								
								
							</ul>
						</li>
						<li><a href="/index.php/topic,17.0.html">Правила</a></li>	
					</ul>
				</div>
			</div>
		</div>
	</div>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// List the buttons in reverse order for RTL languages.
	if ($context['right_to_left'])
		$button_strip = array_reverse($button_strip, true);

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><i class="fa fa-'.$key.' fa-fw"></i><span>' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="buttonlist', !empty($direction) ? ' float' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>
			<ul class="nav nav-pills">',
				implode('', $buttons), '
			</ul>
		</div>';
}
function pages_titlesdesc()
{
	global  $context;

		echo '
		<h1>',$context['page_title'],'</h1>';

}


?>
