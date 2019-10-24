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

/**
 * Privacy class for requesting user data.
 *
 * @package    collabora
 * @copyright  2019 Justus Dieckmann, WWU; based on code by Benjamin Ellis, Synergy Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_collabora\privacy;

defined('MOODLE_INTERNAL') || die();

global $CFG;

use \core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\context;
use \core_privacy\local\request\contextlist;

/**
 * Privacy class for requesting user data.
 *
 * @package    collabora
 * @copyright  2019 Justus Dieckmann, WWU; based on code by Benjamin Ellis, Synergy Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
        \core_privacy\local\metadata\provider,
        \core_privacy\local\request\plugin\provider {

    /**
     * Return meta data about this plugin.
     *
     * @param collection $collection A list of information to add to.
     * @return collection Return the collection after adding to it.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_subsystem_link('core_files', [], 'privacy:metadata:core_files');
        $collection->add_external_location_link('collabora_extsystem', [
                'UserFriendlyName' => 'privacy:metadata:collabora_extsystem:username',
                'LastModifiedTime' => 'privacy:metadata:collabora_extsystem:lastmodified',
                'FileContent' => 'privacy:metadata:collabora_extsystem:filecontent'
        ], 'privacy:metadata:collabora_extsystem');
        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return  contextlist   $contextlist  The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        // We don't delete files, because they was submitted as a group. To avoid confusion, we don't export them either.
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        // We don't delete files, because they was submitted as a group. To avoid confusion, we don't export them either.
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        // We don't delete files, because they was submitted as a group. To avoid confusion, we don't export them either.
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        // We don't delete files, because they was submitted as a group. To avoid confusion, we don't export them either.
    }
}
