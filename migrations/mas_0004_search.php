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

class mas_0004_search extends migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0003_viewforum');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas_sh_fp_av', 0)),
			array('config.add', array('dark1_mas_sh_fp_ol', 0)),
			array('config.add', array('dark1_mas_sh_fp_av_sz', 20)),
			array('config.add', array('dark1_mas_sh_lp_av', 0)),
			array('config.add', array('dark1_mas_sh_lp_ol', 0)),
			array('config.add', array('dark1_mas_sh_lp_av_sz', 20)),
			array('config.add', array('dark1_mas_sh_up_av', 0)),
			array('config.add', array('dark1_mas_sh_up_ol', 0)),
			array('config.add', array('dark1_mas_sh_up_av_sz', 20)),
		);
	}
}
