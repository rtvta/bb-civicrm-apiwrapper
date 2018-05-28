<?php
require_once 'api/Wrapper.php';

class CRM_Restapiwrapper_APIWrapper implements API_Wrapper {
    /**
     * the wrapper contains a method that allows you to alter the parameters of the api request (including the action and the entity)
     */


    public function fromApiInput($apiRequest) {
        $sender = CRM_Utils_Array::value('sender', $apiRequest['params']);
        switch ($sender) {
            case "Infusionsoft":
                $email = trim(CRM_Utils_Array::value('email1', $apiRequest['params']));
                $phone = trim(CRM_Utils_Array::value('phone1', $apiRequest['params']));
                $last_name = trim(CRM_Utils_Array::value('last_name', $apiRequest['params']));
                $first_name = trim(CRM_Utils_Array::value('first_name', $apiRequest['params']));
                $contactId = null;

                if (!empty($phone)) {
                    $apiRequest['params']['api.Phone.create'] = array('phone' => $phone,
                        'location_type_id' => 5,
                    );
                    $contactId = (is_null($contactId) ? self::searchContactByPhone($phone) : $contactId);
                }

                if (!empty($email)) {
                    $apiRequest['params']['api.Email.create'] = array('email' => $email,
                        'location_type_id' => 5,
                    );
                    $contactId = (is_null($contactId) ? self::searchContactByEmail($email) : $contactId);
                }

                if (!is_null($contactId)) {
                    if (isset($apiRequest['params']['last_name'])) unset($apiRequest['params']['last_name']);
                    if (isset($apiRequest['params']['first_name'])) unset($apiRequest['params']['first_name']);
                    if (isset($apiRequest['params']['api.Email.create'])) unset($apiRequest['params']['api.Email.create']);
                    if (isset($apiRequest['params']['api.Phone.create'])) unset($apiRequest['params']['api.Phone.create']);

                    $apiRequest['params']['id'] = $contactId;
                    return $apiRequest;
                }

                $apiRequest['params']['source'] = "Infusionsoft";
                if (empty($last_name) && empty($first_name)) {
                    $apiRequest['params']['display_name'] = "No Name";

                }
                break;
            default:
                break;
        }
        return $apiRequest;
    }

    /**
     * alter the result before returning it to the caller.
     */
    public function toApiOutput($apiRequest, $result) {
        $sender = CRM_Utils_Array::value('sender', $apiRequest['params']);
        $callingContactId = CRM_Core_Session::singleton()->getLoggedInContactID();
        $callingContactId = empty($callingContactId) ? 33291 : $callingContactId;
        switch ($sender) {
            case "Infusionsoft":
                $tag = CRM_Utils_Array::value('tag1', $apiRequest['params']);
                $phone = trim(CRM_Utils_Array::value('phone1', $apiRequest['params']));
                $actType = CRM_Utils_Array::value('civi_act_type', $apiRequest['params']);
                $campaign_id = CRM_Utils_Array::value('c_campaign', $apiRequest['params']);
                $civiConId = null;

                /*Prod env custom fields*/
                $actCustomValue = array('sequential' => 1,
                    'custom_507' => CRM_Utils_Array::value('c_source', $apiRequest['params']),
                    'custom_508' => CRM_Utils_Array::value('c_page', $apiRequest['params']),
                    'custom_509' => CRM_Utils_Array::value('c_medium', $apiRequest['params']),
                    'custom_510' => CRM_Utils_Array::value('c_term', $apiRequest['params']),
                    'custom_511' => CRM_Utils_Array::value('c_content', $apiRequest['params']),
                    'custom_114' => CRM_Utils_Array::value('c_branch', $apiRequest['params']),
                );


                if (isset($result['id']) && !empty($result['id'])) {
                    $civiConId = $result['id'];
                    if (!empty($tag) && !empty($actType)) {
                        try {
                            $civiAct = civicrm_api3('Activity', 'create', array('sequential' => 1,
                                'source_contact_id' => $callingContactId,
                                'target_id' => $civiConId,
                                'activity_type_id' => $actType,
                                'campaign_id' => $campaign_id,
                                'subject' => $tag,
                                'phone_number' => $phone,
                            ));

                            if (isset($civiAct['id']) && !empty($civiAct['id'])) {
                                $actCustomValue['entity_id'] = $civiAct['id'];
                                civicrm_api3('CustomValue', 'create', $actCustomValue);
                            }
                        }
                        catch (CiviCRM_API3_Exception $e) {
                            // Handle error here.
                            $errorMessage = $e->getMessage();
                            $errorCode = $e->getErrorCode();
                            $errorData = $e->getExtraParams();
                            return array(
                                'is_error' => 1,
                                'error_message' => $errorMessage,
                                'error_code' => $errorCode,
                                'error_data' => $errorData,
                            );
                        }
                    }
                }

                break;
            default:
                break;
        }
        return $result;
    }

    private function searchContactByEmail($email) {
        $contactId = null;
        $sql = "SELECT e.contact_id FROM civicrm_email e WHERE e.is_primary = 1 AND e.email = '{$email}'";
        $dao = CRM_Core_DAO::executeQuery($sql);
        if ($dao->fetch()) {
            $contactId = $dao->contact_id;
        }
        return $contactId;
    }

    private function searchContactByPhone($phone) {
        $contactId = null;
        $sql = "SELECT p.contact_id FROM civicrm_phone p WHERE p.is_primary = 1 AND p.phone = '{$phone}'";
        $dao = CRM_Core_DAO::executeQuery($sql);
        if ($dao->fetch()) {
            $contactId = $dao->contact_id;
        }
        return $contactId;
    }
}
