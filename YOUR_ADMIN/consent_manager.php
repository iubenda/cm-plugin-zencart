<?php
/**
 * Consent Manager for Zen Cart
 *
 * @package   Consent_Manager
 * @copyright 2021 Consent Manager
 * @version   1.0.0
 *
 */

define('HEADING_TITLE', 'Consent Manager Installation Check');



// used when the code has been successfully inserted
define(
    'SUCCESS_ON_CODE_INSERT',
    'Code inserted'
);

// used when code insertion fails - usually due to permission porblems
define(
    'FAIL_ON_CODE_INSERT',
    'The code could not be Inserted.'
);

// used when code insertion fails because the code already exists
define(
    'CODE EXISTS',
    'The code has previously been inserted. No action taken.'
);

// backup does not exist
define(
    'CM_BACKUP_DOES_NOT_EXIST',
    'A backup version does not exist'
);

// could not save restored version
define(
    'CM_FILEPUT_FAILED',
    'Rollback failed - could not save file'
);

// could not save restored version
define(
    'CM_ROLLBACKSUCCESS',
    'Rollback success'
);

// description when code found
define(
    'CM_DESCRIPTION_CODE_FOUND',
    'The correct code has been inserted into the html_header file.
    <br/>
    Check that your site is working correctly.'
);

// button when code found
define(
    'CM_DESCRIPTION_CODE_FOUND_BUTTON',
    'Try to rollback?'
);


// description when code not found
define(
    'CM_DESCRIPTION_CODE_NOT_FOUND',
    'The correct code is not present in the html_header file.
    <br/>
    We can try to insert in automatically.'
);

// button when code not found
define(
    'CM_DESCRIPTION_CODE_NOT_FOUND_BUTTON',
    'Insert the code?'
);

// description when automatic is impossible
define(
    'CM_DESCRIPTION_MANUAL_CODE_NEEDED',
    'The correct code is not present in the html_header file. 
        We cannot insert it automatically in your template. 
        You must insert it manually.
        <br/>See the plugin documentation for more details.'
);


// description - modeule is correctly installed
define(
    'CM_MODULE_PRESENT',
    'The module file (includes/modules/consent_manager.php) is installed correctly'
);

// description - module is not correctly installed
define(
    'CM_MODULE_NOT_PRESENT',
    'The module file is not installed correctly. 
    You should upload <b>includes/modules/consent_manager.php</b> from the package.'
);


// description - goto settings
define(
    'CM_GO_TO_SETTINGS',
    'Everything is installed correctly. You can proceed to the settings page.'
);

// button - goto settings
define(
    'CM_GO_TO_SETTINGS_BUTTON',
    'Go to Settings'
);

// description - do not go to settings
define(
    'CM_NO_TO_SETTINGS',
    'Please resolve the issues above before proceeding to the module settings.'
);



// description - uninstall module
define(
    'CM_UNINSTALL',
    'Do you wish to uninstall this module?'
);

// button - uninstall module
define(
    'CM_UNINSTALL_BUTTON',
    'Uninstall?'
);



