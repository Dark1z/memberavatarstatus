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

class mas_0006_general extends migration
{
	static public function depends_on()
	{
		return array('\dark1\memberavatarstatus\migrations\mas_0005_review');
	}

	public function update_data()
	{
		return array(
			// Config Add
			array('config.add', array('dark1_mas_avatar', 0)),
			array('config.add', array('dark1_mas_online', 0)),
			array('config.add', array('dark1_mas_col_off', '000000')),
			array('config.add', array('dark1_mas_col_on', '00FF00')),
		);
	}
}
