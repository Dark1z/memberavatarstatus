<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 *
 * Language : English [en]
 * Translators :
 * 1. Dark❶ [dark1]
 *
 *
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_MAS_BY'				=> 'By',
	'ACP_MAS_DEV_BY'			=> 'Developed By',

	// ACP MAS Setting Page Common Elements
	'ACP_MAS_AVATAR'			=> 'Avatar Enable',
	'ACP_MAS_AV_SIZE'			=> 'Avatar Size',
	'ACP_MAS_AV_SIZE_PX'		=> 'Pixel [px]',
	'ACP_MAS_AV_SZ_BIG_EXPLAIN'	=> 'Set’s the Size of Avatar in Pixels [px],<br />Allowed Between 9px to 999px Only.<br />Default : 50px',
	'ACP_MAS_AV_SZ_SML_EXPLAIN'	=> 'Set’s the Size of Avatar in Pixels [px],<br />Allowed Between 9px to 99px Only.<br />Default : 20px',
	'ACP_MAS_ONLINE'			=> 'Online Status Enable',

	// ACP MAS Setting Page Non-Common Elements
	'ACP_MAS_PHPBB_AV_SET'		=> 'phpBB Avatar Setting',
	'ACP_MAS_PHPBB_AV_LB'		=> 'Enable Avatars',
	'ACP_MAS_PHPBB_AV_EXPLAIN'	=> 'None of the bellow Avatar setting will work,<br />Because phpBB Avatar is Disabled.<br />Enable it Here : ',
	'ACP_MAS_PHPBB_OL_SET'		=> 'phpBB Online Status Setting',
	'ACP_MAS_PHPBB_OL_LB'		=> 'Enable Display of User Online/Offline Information',
	'ACP_MAS_PHPBB_OL_EXPLAIN'	=> 'None of the bellow Online Status setting will work,<br />Because phpBB Online Status is Disabled.<br />Enable it Here : ',
	// Memberlist
	'ACP_MAS_ML_AV_SET'			=> 'Avatar Setting',
	'ACP_MAS_ML_AV_LB'			=> 'Avatar Enable',
	'ACP_MAS_ML_AV_EXPLAIN'		=> 'Enables the Avatar in Memberlist,<br />That is in “The team” , “Groups” & “Members” Page.<br />Default : No',
	'ACP_MAS_ML_AV_SZ_LB'		=> 'Avatar Size',
	'ACP_MAS_ML_OL_SET'			=> 'Online Status Setting',
	'ACP_MAS_ML_OL_LB'			=> 'Online Status Enable',
	'ACP_MAS_ML_OL_EXPLAIN'		=> 'Enables the Online Status in Memberlist,<br />That is in “The team” , “Groups” & “Members” Page.<br />Default : No',
	// Viewonline
	'ACP_MAS_VO_PG_AV_SET'		=> 'Page Avatar Setting',
	'ACP_MAS_VO_PG_AV_LB'		=> 'Page Avatar Enable',
	'ACP_MAS_VO_PG_AV_EXPLAIN'	=> 'Enables the Avatar in Viewonline Page,<br />That is in “Who is online” Page.<br />Default : No',
	'ACP_MAS_VO_PG_AV_SZ_LB'	=> 'Page Avatar Size',
	'ACP_MAS_VO_SB_AV_SET'		=> 'Stat Block Avatar Setting',
	'ACP_MAS_VO_SB_AV_LB'		=> 'Stat Block Avatar Enable',
	'ACP_MAS_VO_SB_AV_EXPLAIN'	=> 'Enables the Avatar in Viewonline Stat Block,<br />That is in Statistic “Who is online” Block at Bottom of every Page.<br />Default : No',
	'ACP_MAS_VO_SB_AV_SZ_LB'	=> 'Stat Block Avatar Size',
	// Viewforum
	'ACP_MAS_VF_FP_SET'			=> 'First Poster Setting',
	'ACP_MAS_VF_FP_AV_LB'		=> 'First Poster Avatar Enable',
	'ACP_MAS_VF_FP_AV_EXPLAIN'	=> 'Enables the First Poster Avatar in Viewforum,<br />That is in All Forum’s Pages.<br />Default : No',
	'ACP_MAS_VF_FP_AV_SZ_LB'	=> 'First Poster Avatar Size',
	'ACP_MAS_VF_FP_OL_LB'		=> 'First Poster Online Status Enable',
	'ACP_MAS_VF_FP_OL_EXPLAIN'	=> 'Enables the First Poster Online Status in Viewforum,<br />That is in All Forum’s Pages.<br />Default : No',
	'ACP_MAS_VF_LP_SET'			=> 'Last Poster Setting',
	'ACP_MAS_VF_LP_AV_LB'		=> 'Last Poster Avatar Enable',
	'ACP_MAS_VF_LP_AV_EXPLAIN'	=> 'Enables the Last Poster Avatar in Viewforum,<br />That is in All Forum’s Pages & Index Page.<br />Default : No',
	'ACP_MAS_VF_LP_AV_SZ_LB'	=> 'Last Poster Avatar Size',
	'ACP_MAS_VF_LP_OL_LB'		=> 'Last Poster Online Status Enable',
	'ACP_MAS_VF_LP_OL_EXPLAIN'	=> 'Enables the Last Poster Online Status in Viewforum,<br />That is in All Forum’s Pages & Index Page.<br />Default : No',
	// Search
	'ACP_MAS_SH_FP_SET'			=> 'Topic First Poster Setting',
	'ACP_MAS_SH_FP_AV_LB'		=> 'Topic First Poster Avatar Enable',
	'ACP_MAS_SH_FP_AV_EXPLAIN'	=> 'Enables the Topic First Poster Avatar in Search,<br />That is in All Topic Search Pages.<br />Default : No',
	'ACP_MAS_SH_FP_AV_SZ_LB'	=> 'Topic First Topic Poster Avatar Size',
	'ACP_MAS_SH_FP_OL_LB'		=> 'Topic First Poster Online Status Enable',
	'ACP_MAS_SH_FP_OL_EXPLAIN'	=> 'Enables the Topic First Poster Online Status in Search,<br />That is in All Topic Search Pages.<br />Default : No',
	'ACP_MAS_SH_LP_SET'			=> 'Topic Last Poster Setting',
	'ACP_MAS_SH_LP_AV_LB'		=> 'Topic Last Poster Avatar Enable',
	'ACP_MAS_SH_LP_AV_EXPLAIN'	=> 'Enables the Topic Last Poster Avatar in Search,<br />That is in All Topic Search Pages.<br />Default : No',
	'ACP_MAS_SH_LP_AV_SZ_LB'	=> 'Topic Last Poster Avatar Size',
	'ACP_MAS_SH_LP_OL_LB'		=> 'Topic Last Poster Online Status Enable',
	'ACP_MAS_SH_LP_OL_EXPLAIN'	=> 'Enables the Topic Last Poster Online Status in Search,<br />That is in All Topic Search Pages.<br />Default : No',
	'ACP_MAS_SH_UP_SET'			=> 'Post User Setting',
	'ACP_MAS_SH_UP_AV_LB'		=> 'Post User Avatar Enable',
	'ACP_MAS_SH_UP_AV_EXPLAIN'	=> 'Enables the Post User Avatar in Search,<br />That is in All Post Search Pages.<br />Default : No',
	'ACP_MAS_SH_UP_AV_SZ_LB'	=> 'Post User Avatar Size',
	'ACP_MAS_SH_UP_OL_LB'		=> 'Post User Online Status Enable',
	'ACP_MAS_SH_UP_OL_EXPLAIN'	=> 'Enables the Post User Online Status in Search,<br />That is in All Post Search Pages.<br />Default : No',
));
