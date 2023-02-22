<?php
/**
 * Consent Manager for Zen Cart
 *
 * @package   Consent_Manager
 * @copyright 2021 Consent Manager
 * @version   1.0.0
 *
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
} 

// uncomment the following line to perform a manual uninstall
// $_SESSION['consent_manager_uninstall'] == 'uninstall';


$autoLoadConfig[199][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_consent_manager.php'
    );  


