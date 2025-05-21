<?php
/**
 *
 * Template event prioritizing extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, rxu, https://www.phpbbguru.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace rxu\templateventsort\tests\functional;

/**
 * @group functional
 */
class templateventsort_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return ['rxu/templateventsort'];
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->login();
		$this->admin_login();
	}

	public function test_index_page()
	{
		$crawler = self::request('GET', "index.php");
		$this->assertEquals(1, $crawler->filter('div.forabg')->count());
		$this->assertStringContainsString('Your first category', $crawler->filter('div.list-inner')->text());
	}
}
