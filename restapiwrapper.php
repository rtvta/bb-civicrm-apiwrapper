<?php

require_once 'restapiwrapper.civix.php';
require_once 'CRM/Restapiwrapper/APIWrapper.php';
    
/**
* Implements hook_civicrm_apiWrappers().
*/
function restapiwrapper_civicrm_apiWrappers(&$wrappers, $apiRequest) {
    //&apiWrappers is an array of wrappers, you can add your(s) with the hook.
    // You can use the apiRequest to decide if you want to add the wrapper (eg. only wrap api.Contact.create)
    if ($apiRequest['entity'] == "Contact" && $apiRequest['action'] == "create") {
        $wrappers[] = new CRM_Restapiwrapper_APIWrapper();
    }
}
/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function restapiwrapper_civicrm_config(&$config) {
  _restapiwrapper_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function restapiwrapper_civicrm_xmlMenu(&$files) {
  _restapiwrapper_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function restapiwrapper_civicrm_install() {
  _restapiwrapper_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function restapiwrapper_civicrm_postInstall() {
  _restapiwrapper_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function restapiwrapper_civicrm_uninstall() {
  _restapiwrapper_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function restapiwrapper_civicrm_enable() {
  _restapiwrapper_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function restapiwrapper_civicrm_disable() {
  _restapiwrapper_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function restapiwrapper_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _restapiwrapper_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function restapiwrapper_civicrm_managed(&$entities) {
  _restapiwrapper_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function restapiwrapper_civicrm_caseTypes(&$caseTypes) {
  _restapiwrapper_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function restapiwrapper_civicrm_angularModules(&$angularModules) {
  _restapiwrapper_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function restapiwrapper_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
    _restapiwrapper_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
    
// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function restapiwrapper_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function restapiwrapper_civicrm_navigationMenu(&$menu) {
  _restapiwrapper_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'info.kabbalah.restapiwrapper')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _restapiwrapper_civix_navigationMenu($menu);
} // */
