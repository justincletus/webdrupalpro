<?php

namespace Drupal\registration_role_with_approval\Controller;

use Drupal\Core\Controller\ControllerBase;


class RegistrationRoleWithApprovalController extends ControllerBase {

  public static function roles() {

    $available_roles = array();
    $system_roles = user_roles();
    foreach($system_roles as $system_role){
      $available_roles[$system_role->id()] = $system_role->label();
    }
    $display_roles = array(
      "#type" => "checkboxes",
      "#title" => t('Choose roles'),
      "#options" => $available_roles,
    );

    return $display_roles;
  }

}


?>