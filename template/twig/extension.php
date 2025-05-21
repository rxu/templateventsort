<?php
/**
 *
 * Template event prioritizing extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace rxu\templateventsort\template\twig;

class extension extends \phpbb\template\twig\extension
{
	/**
	* Returns the token parser instance to add to the existing list.
	*
	* @return array An array of \Twig\TokenParser\AbstractTokenParser instances
	*/
	public function getTokenParsers()
	{
		return array(
			new \phpbb\template\twig\tokenparser\defineparser,
			new \phpbb\template\twig\tokenparser\includeparser,
			new \phpbb\template\twig\tokenparser\includejs,
			new \phpbb\template\twig\tokenparser\includecss,
			new \rxu\templateventsort\template\twig\tokenparser\event($this->environment),
			new \phpbb\template\twig\tokenparser\includephp($this->environment),
			new \phpbb\template\twig\tokenparser\php($this->environment),
		);
	}
}
