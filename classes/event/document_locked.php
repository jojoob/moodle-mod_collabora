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
 * The mod_collabora document locked event.
 *
 * @package    mod_collabora
 * @copyright  2019 Davo Smith, Synergy Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_collabora\event;

/**
 * The mod_collabora document locked event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int groupid: The groupid this document is for.
 *      - int collaboraid: The collabora id the document is part of.
 * }
 *
 * @package    mod_collabora
 * @copyright  2019 Davo Smith, Synergy Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class document_locked extends \core\event\base {

    public static function trigger_from_document($cmid, $document) {
        $params = [
            'context' => \context_module::instance($cmid),
            'objectid' => $document->id,
            'other' => [
                'groupid' => $document->groupid,
                'collaboraid' => $document->collaboraid,
            ],
        ];
        $event = self::create($params);
        $event->add_record_snapshot('collabora_document', $document);
        $event->trigger();
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'collabora_document';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has locked the document with id '$this->objectid' for group id ".
            "'{$this->other['groupid']}' in the collaborative documument with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventdocumentlocked', 'mod_collabora');
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/collabora/view.php', ['id' => $this->contextinstanceid, 'group' => $this->other['groupid']]);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['groupid'])) {
            throw new \coding_exception('The \'groupid\' value must be set in other.');
        }

        if (!isset($this->other['collaboraid'])) {
            throw new \coding_exception('The \'collaboraid\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }

    public static function get_objectid_mapping() {
        return array('db' => 'collabora_document', 'restore' => 'collabora_document');
    }

    public static function get_other_mapping() {
        $othermapped = array();
        $othermapped['collaboraid'] = array('db' => 'collabora', 'restore' => 'collabora');
        $othermapped['groupid'] = array('db' => 'group', 'restore' => 'group');

        return $othermapped;
    }
}
