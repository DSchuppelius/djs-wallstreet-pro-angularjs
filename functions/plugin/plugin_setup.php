<?php
/*
 * Created on   : Wed Jun 22 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : plugin_setup.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

if(!class_exists('Plugin_Setup')) {
    abstract class Plugin_Setup extends Plugin_Base {
        protected $current_data;

        public function get($key) {
            $result = null;

            if (array_key_exists($key, $this->current_data)) {
                if(is_bool($this->__get($key))) {
                    $result = sanitize_boolean_field($this->current_data[$key]);
                } else {
                    $result = $this->current_data[$key];
                }
            } else {
                $result = $this->__get($key);
            }

            return $result;
        }

        protected function load_current_setup() {
            $this->current_data = $this->get_current_setup();
        }

        public function get_current_setup() {
            return wp_parse_args(get_option("wallstreet_pro_options", []), $this->data);
        }
    }
}

require_once(DJS_ANGULARJS_PLUGIN_DIR . "plugin_setup_data.php"); ?>
