<?php
    class Obscura extends Modules {
        static function __install() {
            $set = array(Config::current()->set("module_obscura",
                                            array("background" => "grey",
                                                  "spacing" => "24",
                                                  "protect" => true )));
        }

        static function __uninstall() {
            Config::current()->remove("module_obscura");
        }

        static function admin_obscura_settings($admin) {
            if (!Visitor::current()->group->can("change_settings"))
                show_403(__("Access Denied"), __("You do not have sufficient privileges to change settings."));
    
            if (empty($_POST))
                return $admin->display("obscura_settings");
    
            if (!isset($_POST['hash']) or $_POST['hash'] != Config::current()->secure_hashkey)
                show_403(__("Access Denied"), __("Invalid security key."));

            $set = array(Config::current()->set("module_obscura",
                                            array("background" => $_POST['background'],
                                                  "spacing" => $_POST['spacing'],
                                                  "protect" => isset($_POST['protect']))));

            if (!in_array(false, $set))
                Flash::notice(__("Settings updated."), "/admin/?action=obscura_settings");
        }

        static function settings_nav($navs) {
            if (Visitor::current()->group->can("change_settings"))
                $navs["obscura_settings"] = array("title" => __("Obscura", "obscura"));
            return $navs;
        }

        static function scripts($scripts) {
            $scripts[] = Config::current()->chyrp_url."/modules/obscura/javascript.php";
            return $scripts;
        }
    }
