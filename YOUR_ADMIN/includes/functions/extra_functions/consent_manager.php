<?php
/**
 * Consent Manager for Zen Cart
 *
 * @package   Consent_Manager
 * @copyright 2021 Consent Manager
 * @version   1.0.0
 *
 */



/**
 * Function to render the pn page blocks
 * 
 * @param array $block - array of block contents
 * 
 * @return html
 */
function CM_Render_block($block) {
    $output = '
    <div class="CM_block">
    <table width="100%">
    <tr>
        <td width="50px">'.$block['icon'].'
        </td>
        <td>'.$block['description'].'
        </td>
    </tr>
    <tr>
        <td colspan = "2" class="CM_action" align="center">
        <br/><br/>'.$block['action'].'
        </td>
    </tr>
    </table>
    </div>
    ';

    return $output;
}

