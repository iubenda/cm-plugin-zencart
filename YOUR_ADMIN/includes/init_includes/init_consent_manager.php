<?php
/**
 * Consent Manager for Zen Cart
 *
 * @package   Consent_Manager
 * @copyright 2021 Consent Manager
 * @version   1.0.0
 *
 */

if (isset($_SESSION['consent_manager_uninstall']) && $_SESSION['consent_manager_uninstall'] == 'uninstall') {
    define('CONSENT_MANAGER_UNINSTALL', 'uninstallNow');
} else {
    define('CONSENT_MANAGER_UNINSTALL', 'notNow');
}





if (CONSENT_MANAGER_UNINSTALL == 'uninstallNow') {
    // do uninstall
    $install = new InstallConsentManager;
    $install->executeUninstall();
} elseif (!defined("CONSENT_MANAGER_ENABLED")) {
    // do install
    $install = new InstallConsentManager;
    $install->executeInstall();
}


if (defined("CONSENT_MANAGER_ENABLED") && CONSENT_MANAGER_ENABLED == 'true') {
    $check = new ConsentManagerCheck;
    $check->check();
}


/**
 * ConsentManagerCheck Class Doc Comment
 *
 * @category Class
 * @package  Consent_Manager
 */
class ConsentManagerCheck
{

    /**
     * Checks for the user inputs
     *
     * @return false
     */
    public function check()
    {
        global $messageStack, $db;
        if (false == $this->checkCMPID()) {
            $messageStack->add(
                'Consent Manager CPM-ID is an incorrect format. 
                Please correct this error in order enable the module',
                'error'
            );
            $messageStack->add(
                'The CPM-ID is numeric and has at least five digits.',
                'error'
            );

            $sql = "UPDATE " . 
                    TABLE_CONFIGURATION . " 
                    SET configuration_value = 'false' 
                    WHERE configuration_key = 'CONSENT_MANAGER_ENABLED'";
            $db->Execute($sql);
        }
        return false;
    }

    /**
     * Check CPMID is valid
     * 
     * @return boolean
     */  
    public function checkCMPID()
    {
        if (!is_numeric(CONSENT_MANAGER_CMPID)) {
            return false;
        }

        if (strlen(CONSENT_MANAGER_CMPID) < 4) {
            //return false;
        }

        return true;
    }
}


/**
 * ConsentManagerCheck Class Doc Comment
 *
 * @category Class
 * @package  Consent_Manager
 */
class InstallConsentManager
{


    /**
     * Install Consent Manager
     *
     * @return false
     */
    public function executeInstall()
    {
        global $db, $messageStack;


        /* ================================== Configuration Group */

        $sql   = "SELECT configuration_group_id 
                    FROM " . TABLE_CONFIGURATION_GROUP . " 
                    WHERE configuration_group_title = 'Consent Manager'";
        $check = $db->Execute($sql);

        if ($check->RecordCount()) {
            $config_group = intval($check->fields['configuration_group_id']);
        } else {
            $sql    = "SELECT max(sort_order) as largest 
                        FROM " . TABLE_CONFIGURATION_GROUP;
            $result = $db->Execute($sql);

            $config_group = intval($result->fields['largest'] + 1);

            $sql = "INSERT INTO " . TABLE_CONFIGURATION_GROUP . "
              (configuration_group_id,
              configuration_group_title,
              configuration_group_description,
              sort_order,
              visible)
              VALUES
              (NULL,
              'Consent Manager',
              'Set Consent Manager Options',
              " . $config_group . ",
              '1')";
            $db->Execute($sql);
        }


        /* ================================== EOF Configuration Group */

        /* ================================== Register admin pages */

        zen_deregister_admin_pages('configConsentManager');
        zen_register_admin_page(
            'configConsentManager',
            'MENU_CONSENT_MANAGER_CONFIGURATION',
            'FILENAME_CONFIGURATION',
            'gID=' . $config_group,
            'configuration',
            'Y',
            $config_group
        );


        zen_deregister_admin_pages('consentManager');
        zen_register_admin_page(
            'consentManager',
            'MENU_CONSENT_MANAGER',
            'FILENAME_CONSENT_MANAGER',
            '',
            'tools',
            'Y',
            '987'
        );

        /* ================================== EOF Register admin pages */

        $c_key   = 'CONSENT_MANAGER_ENABLED';
        $default = 'false';

        $title = $c_key . '_TITLE';
        $text  = $c_key . '_TEXT';

        $sql     = "SELECT configuration_value 
                    FROM " . TABLE_CONFIGURATION . " 
                    WHERE configuration_key = '" . $c_key . "' 
                    LIMIT 1";
        $results = $db->Execute($sql);

        $config_value = ($results->fields['configuration_value'] != '') ?
                        $results->fields['configuration_value'] :
                        $default;
        $sql          = "DELETE 
                            FROM " . 
                            TABLE_CONFIGURATION . " 
                            WHERE configuration_key = '" . $c_key . "'";
        $db->Execute($sql);

        $sql = "
            INSERT INTO " . TABLE_CONFIGURATION . "
              (configuration_id,
              configuration_title,
              configuration_key,
              configuration_value,
              configuration_description,
              configuration_group_id,
              sort_order,
              last_modified,
              date_added,
              use_function,
              set_function)
              VALUES
              (NULL,
              '" . constant($title) . "',
              '" . $c_key . "',
              '" . $config_value . "',
              '" . constant($text) . "',
              " . $config_group . ",
              10,
              now(),
              now(),
              NULL,
              'zen_cfg_select_option(array(''true'',''false''),'
            )";

        $db->Execute($sql);

        //======================================================

        $c_key   = 'CONSENT_MANAGER_BLOCKING_MODE';
        $default = 'automatic';

        $title = $c_key . '_TITLE';
        $text  = $c_key . '_TEXT';

        $sql     = "SELECT configuration_value 
                    FROM " . TABLE_CONFIGURATION . " 
                    WHERE configuration_key = '" . $c_key . "' 
                    LIMIT 1";
        $results = $db->Execute($sql);

        $config_value = ($results->fields['configuration_value'] != '') ?
                        $results->fields['configuration_value'] :
                        $default;
        $sql          = "DELETE 
                            FROM " . TABLE_CONFIGURATION . " 
                            WHERE configuration_key = '" . $c_key . "'";
        $db->Execute($sql);

        $sql = "
            INSERT INTO " . TABLE_CONFIGURATION . "
              (configuration_id,
              configuration_title,
              configuration_key,
              configuration_value,
              configuration_description,
              configuration_group_id,
              sort_order,
              last_modified,
              date_added,
              use_function,
              set_function)
              VALUES
              (NULL,
              '" . constant($title) . "',
              '" . $c_key . "',
              '" . $config_value . "',
              '" . constant($text) . "',
              " . $config_group . ",
              20,
              now(),
              now(),
              NULL,
              'zen_cfg_select_option(array(''automatic'',''semiautomatic''),'
            )";
        $db->Execute($sql);

        //======================================================

        $c_key   = 'CONSENT_MANAGER_CMPID';
        $default = '0';

        $title = $c_key . '_TITLE';
        $text  = $c_key . '_TEXT';

        $sql     = "SELECT configuration_value 
                    FROM " . TABLE_CONFIGURATION . " 
                    WHERE configuration_key = '" . $c_key . "' 
                    LIMIT 1";
        $results = $db->Execute($sql);

        $config_value = ($results->fields['configuration_value'] != '') ?
                        $results->fields['configuration_value'] :
                        $default;
        $sql          = "DELETE 
                            FROM " . TABLE_CONFIGURATION . " 
                            WHERE configuration_key = '" . $c_key . "'";
        $db->Execute($sql);

        $sql = "
            INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_id,
                configuration_title,
                configuration_key,
                configuration_value,
                configuration_description,
                configuration_group_id,
                sort_order, last_modified,
                date_added,
                use_function,
                set_function
            ) VALUES (
                NULL, '" .
        constant($title) . "',
                '" . $c_key . "',
                '" . $config_value . "',
                '" . constant($text) . "',
                " . $config_group . ",
                15,
                now(),
                now(),
                NULL,
                NULL
            )";

        $db->Execute($sql);
        //======================================================

        $c_key   = 'CONSENT_MANAGER_HTML';
        $default = '';

        $title = $c_key . '_TITLE';
        $text  = $c_key . '_TEXT';

        $sql     = "SELECT configuration_value 
                    FROM " . TABLE_CONFIGURATION . " 
                    WHERE configuration_key = '" . $c_key . "' 
                    LIMIT 1";
        $results = $db->Execute($sql);

        $config_value = ($results->fields['configuration_value'] != '') ?
                        $results->fields['configuration_value'] :
                        $default;
        $sql          = "DELETE 
                            FROM " . TABLE_CONFIGURATION . " 
                            WHERE configuration_key = '" . $c_key . "'";
        $db->Execute($sql);

        $sql = "
            INSERT INTO " . TABLE_CONFIGURATION . "
              (configuration_id,
              configuration_title,
              configuration_key,
              configuration_value,
              configuration_description,
              configuration_group_id,
              sort_order,
              last_modified,
              date_added,
              use_function,
              set_function)
              VALUES
              (NULL,
              '" . constant($title) . "',
              '" . $c_key . "',
              '" . $config_value . "',
              '" . constant($text) . "',
              " . $config_group . ",
              40,
              now(),
              now(),
              NULL,
              'zen_cfg_textarea_small('
            )";
        $db->Execute($sql);

        
        //======================================================

        $messageStack->add_session('Consent Manager Installed. ', 'success');

        zen_redirect(zen_href_link(FILENAME_CONSENT_MANAGER));
    }

    /**
     * Uninstall Consent Manager
     *
     * @return false
     */
    public function executeUninstall()
    {
        global $db, $messageStack;


        $files = array(
            DIR_FS_ADMIN.'includes/auto_loaders/config.consent_manager.php',
            DIR_FS_ADMIN.'includes/extra_datafiles/consent_manager.php',
            DIR_FS_ADMIN.'includes/functions/extra_functions/consent_manager.php',
            DIR_FS_ADMIN.'includes/init_includes/init_consent_manager.php',
            DIR_FS_ADMIN.'includes/languages/english/extra_definitions/consent_manager.php',
            DIR_FS_ADMIN.'includes/languages/english/consent_manager.php',
            DIR_FS_ADMIN.'images/consentmanager_logo_thumb.jpg',
            DIR_FS_ADMIN.'consent_manager.php',
            DIR_FS_CATALOG.'includes/modules/consent_manager.php',
        );

        // delete the non-core files
        $fails = 0;
        foreach ($files as $f) {
            if (file_exists($f)) {
                if (unlink($f)) {
                    //$messageStack->add_session('deleted - '.$f, 'success');
                    $fails++;
                } else {

                    $messageStack->add_session('not deleted - '.$f, 'error');
                }
            } else {
                $messageStack->add_session('not there - '.$f, 'error');
            }
        }

        zen_deregister_admin_pages('configConsentManager');
        zen_deregister_admin_pages(['consentManager']);

        $sql = "DELETE 
                FROM " . TABLE_CONFIGURATION_GROUP . " 
                WHERE configuration_group_title = 'Consent Manager'";
        $db->Execute($sql);

        $messageStack->add('Consent Manager Menu Removed', 'success');

        $deleteMap = "
                        'CONSENT_MANAGER_ENABLED',
                        'CONSENT_MANAGER_CMPID',
                        'CONSENT_MANAGER_BLOCKING_MODE',
                        'CONSENT_MANAGER_HTML'
                    ";
        $sql       = "DELETE 
                        FROM " . TABLE_CONFIGURATION . " 
                        WHERE configuration_key IN (" . $deleteMap . ")";
        $db->Execute($sql);

        if ($fails) {

            $messageStack->add_session('Consent Manager Files Removed', 'success');

        }

        $messageStack->add_session('Consent Manager Database Items Removed', 'success');

        $messageStack->add_session('Changes to html_header.php will need to be removed manually.', 'warning');

        unset($_SESSION['consent_manager_uninstall']);

        zen_redirect('index.php');

    }
}
