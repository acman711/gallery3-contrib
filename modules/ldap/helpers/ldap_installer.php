<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class ldap_installer {
  static function install() {
    module::set_version("ldap", 1);
    $root = item::root();
    foreach (identity::groups() as $group) {
      module::event("group_created", $group);
      access::allow($group, "view", $root);
      access::allow($group, "view_full", $root);
    }
    // Let the admin own everything
    $admin = identity::admin_user();
    Database::instance()->query("UPDATE {items} SET owner_id = {$admin->id}");
  }

  static function uninstall() {
    // Delete all groups so that we give other modules an opportunity to clean up
    foreach (identity::groups() as $group) {
      module::event("group_deleted", $group);
    }
  }
}