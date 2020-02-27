<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2020, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus;

/**
 * Member Avatar & Status Extension.
 */
class ext extends \phpbb\extension\base
{
	/** string Require phpBB v3.2.10 due to Events. */
	const MAS_PHPBB_MIN_VERSION = '3.2.10';

	/**
	 * {@inheritdoc}
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return phpbb_version_compare($config['version'], self::MAS_PHPBB_MIN_VERSION, '>=') && phpbb_version_compare(PHPBB_VERSION, self::MAS_PHPBB_MIN_VERSION, '>=');
	}

}
