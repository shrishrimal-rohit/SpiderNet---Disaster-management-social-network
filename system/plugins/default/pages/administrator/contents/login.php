<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

echo '<div class="ossn-admin-login">';
echo '<h3>' . ossn_print('administration') . '</h3>';
echo ossn_view_form('admin/login', array(
    'action' => ossn_site_url('action/admin/login'),
    'class' => 'ossn-admin-form ossn-login-form',
));
echo '</div>';
