<?php
/**
 *
 * Member Avatar & Status [MAS]. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018-2021, Dark❶ [dark1]
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace dark1\memberavatarstatus;

/**
 * @ignore
 */
use phpbb\extension\base;

/**
 * Member Avatar & Status Extension Base
 */
class ext extends base
{
	/** @var string Require phpBB v3.3.4 due to events. */
	const PHPBB_MIN_3_3_X = '3.3.4';

	/**
	 * {@inheritdoc}
	 */
	public function is_enableable()
	{
		return $this->pbpbb_ver_chk();
	}

	/**
	 * phpBB Version Check.
	 *
	 * @return bool
	 */
	private function pbpbb_ver_chk()
	{
		$config = $this->container->get('config');

		$phpbb_version = phpbb_version_compare(PHPBB_VERSION, $config['version'], '>=') ? PHPBB_VERSION : $config['version'] ;

		return phpbb_version_compare($phpbb_version, self::PHPBB_MIN_3_3_X, '>=');
	}
}
