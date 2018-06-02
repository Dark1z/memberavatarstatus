<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

class mas_0003_viewforum extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0002_viewonline');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas_vf_fp_av', 0)),
			array('config.add', array('dark1_mas_vf_fp_ol', 0)),
			array('config.add', array('dark1_mas_vf_fp_av_sz', 20)),
			array('config.add', array('dark1_mas_vf_lp_av', 0)),
			array('config.add', array('dark1_mas_vf_lp_ol', 0)),
			array('config.add', array('dark1_mas_vf_lp_av_sz', 20)),

			// Module Add
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\viewforum_module',
					'modes'				=> array('viewforum'),
				),
			)),
		);
	}
}
