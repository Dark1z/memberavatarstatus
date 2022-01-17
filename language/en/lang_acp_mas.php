<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-forever, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 *
 * Language : English [en]
 * Translators :
 * 1. Dark❶ [dark1]
 *
 *
 */

/**
 * DO NOT CHANGE
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_MAS_BY'				=> 'By',
	'ACP_MAS_DEV_BY'			=> 'Developed By',
	'ACP_MAS_AND'				=> 'and',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Avatar Enable',
	'ACP_MAS_AV_SET'			=> 'Avatar Setting',
	'ACP_MAS_AV_SIZE'			=> 'Avatar Size',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Sets the Size of Avatar in Pixels [px],<br>Allowed Between 9px to 999px Only.<br>Default : 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Sets the Size of Avatar in Pixels [px],<br>Allowed Between 9px to 99px Only.<br>Default : 20px',
	'ACP_MAS_ONLINE'			=> 'Online Status Enable',
	'ACP_MAS_OL_SET'			=> 'Online Status Setting',

	// phpBB
	'ACP_MAS_PHPBB_AV_SET'		=> 'phpBB Avatar Setting',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Enable Avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'None of the bellow Avatar setting will work,<br>Because phpBB Avatar is Disabled.<br>Enable it Here : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'phpBB Online Status Setting',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Enable Display of User Online/Offline Information',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'None of the below Online Status setting will work,<br>Because phpBB Online Status is Disabled.<br>Enable it Here : ',

	// General
	'ACP_MAS_GN_AV_EXPLAIN'		=> 'Enables the Avatar in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_GN_OL_EXPLAIN'		=> 'Enables the Online Status in MAS,<br>This is the Master Switch for All Others.<br>Default : No',
	'ACP_MAS_COL_ON'			=> 'Online Status Color',
	'ACP_MAS_COL_ON_EXPLAIN'	=> 'Color of the Online Status,<br>This is in Hexadecimal [00 to FF] per RGB color codes.<br>Default : “00FF00”',
	'ACP_MAS_COL_OFF'			=> 'Offline Status Color',
	'ACP_MAS_COL_OFF_EXPLAIN'	=> 'Color of the Offline Status,<br>This is in Hexadecimal [00 to FF] per RGB color codes.<br>Default : “000000”',
	// Memberlist
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Enables the Avatar in Memberlist,<br>That is in “The team” , “Groups” & “Members” Page.<br>Default : No',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Enables the Online Status in Memberlist,<br>That is in “The team” , “Groups” & “Members” Page.<br>Default : No',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Page Avatar Setting',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Enables the Avatar in Viewonline Page,<br>That is in “Who is online” Page.<br>Default : No',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Stat Block Avatar Setting',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Enables the Avatar in Viewonline Stat Block,<br>That is in Statistic “Who is online” Block at Bottom of every Page.<br>Default : No',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'First Poster Setting',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Enables the First Poster Avatar in Viewforum,<br>That is in All Forum’s Pages.<br>Default : No',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Enables the First Poster Online Status in Viewforum,<br>That is in All Forum’s Pages.<br>Default : No',
	'ACP_MAS_VF_LP_SET'			=> 'Last Poster Setting',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Enables the Last Poster Avatar in Viewforum,<br>That is in All Forum’s Pages & Index Page.<br>Default : No',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Enables the Last Poster Online Status in Viewforum,<br>That is in All Forum’s Pages & Index Page.<br>Default : No',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Topic First Poster Setting',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Enables the Topic First Poster Avatar in Search,<br>That is in All Topic Search Pages.<br>Default : No',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Enables the Topic First Poster Online Status in Search,<br>That is in All Topic Search Pages.<br>Default : No',
	'ACP_MAS_SH_LP_SET'			=> 'Topic Last Poster Setting',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Enables the Topic Last Poster Avatar in Search,<br>That is in All Topic Search Pages.<br>Default : No',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Enables the Topic Last Poster Online Status in Search,<br>That is in All Topic Search Pages.<br>Default : No',
	'ACP_MAS_SH_UP_SET'			=> 'Post User Setting',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Enables the Post User Avatar in Search,<br>That is in All Post Search Pages.<br>Default : No',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Enables the Post User Online Status in Search,<br>That is in All Post Search Pages.<br>Default : No',
	// Review
	'ACP_MAS_RV_AV_EXPLAIN'		=> 'Enables the Avatar in Review Block,<br>That is in “Posting Topic Review” , “MCP Topic Review” & “PM History Review” Page.<br>Default : No',
	'ACP_MAS_RV_OL_EXPLAIN'		=> 'Enables the Online Status in Review Block,<br>That is in “Posting Topic Review” , “MCP Topic Review” & “PM History Review” Page.<br>Default : No',
	// Friendlist
	'ACP_MAS_FL_AV_EXPLAIN'		=> 'Enables the Avatar in Friendlist,<br>That is in All UCP Pages.<br>Default : No',
	'ACP_MAS_FL_OL_EXPLAIN'		=> 'Enables the Online Status in Friendlist,<br>That is in All UCP Pages.<br>Default : No',
]);
