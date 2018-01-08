<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
?>
<div>
    <label><?php echo ossn_print('username'); ?> </label>
    <input type="text" name="username"/>
</div>

<div>
    <label> <?php echo ossn_print('password'); ?> </label>
    <input type="password" name="password"/>
</div>

<input type="submit" value="<?php echo ossn_print('site:login');?>" class="ossn-button ossn-button-submit"/>
<br/>
<a href="<?php echo ossn_site_url('resetlogin'); ?>"><?php echo ossn_print('reset:password'); ?></a>
