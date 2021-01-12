<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus\migrations;

/**
 * @ignore
 */
use phpbb\db\migration\migration;

class mas_0007_friendlist extends migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0006_general');
	}

	public function update_data()
	{
		return array(
			// Remove Config
			array('config.remove', array('dark1_mas')),

			// Config Add
			array('config.add', array('dark1_mas_fl_av', 0)),
			array('config.add', array('dark1_mas_fl_ol', 0)),
			array('config.add', array('dark1_mas_fl_av_sz', 20)),

			// Module Add
			array('module.add', array(
				'acp',
				'ACP_MAS_TITLE',
				array(
					'module_basename'	=> '\dark1\memberavatarstatus\acp\friendlist_module',
					'modes'				=> array('friendlist'),
				),
			)),
		);
	}
}
