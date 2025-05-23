<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace block_greetings;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/blocks/greetings/lib.php');

/**
 * Greetings library tests
 *
 * @package     block_greetings
 * @copyright   2022 Your name <your@email>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class lib_test extends \advanced_testcase {

    /**
     * Testing the translation of greeting messages.
     *
     * @covers ::block_greetings_get_greeting
     *
     * @dataProvider block_greetings_get_greeting_provider
     * @param string|null $country User country
     * @param string $langstring Greetings message language string
     */
    public function test_block_greetings_get_greeting(?string $country, string $langstring): void {
        $user = null;
        if (!empty($country)) {
            $this->resetAfterTest(true);
            $user = $this->getDataGenerator()->create_user(); // Create a new user.
            $user->country = $country;
        }

        $this->assertSame(get_string($langstring, 'block_greetings', fullname($user)), block_greetings_get_greeting($user));
    }

    /**
     * Data provider for {@see test_block_greetings_get_greeting()}.
     *
     * @return array List of data sets - (string) data set name => (array) data
     */
    public static function block_greetings_get_greeting_provider(): array {
        return [
            'No user' => [ // Not logged in.
                'country' => null,
                'langstring' => 'greetinguser',
            ],
            'AU user' => [
                'country' => 'AU',
                'langstring' => 'greetinguserau',
            ],
            'ES user' => [
                'country' => 'ES',
                'langstring' => 'greetinguseres',
            ],
            'VU user' => [ // Logged in user, but no local greeting.
                'country' => 'VU',
                'langstring' => 'greetingloggedinuser',
            ],
        ];
    }
}
