<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
?>
<style>
    #toplevel_page_vcv-settings.vcv-go-premium .wp-submenu,
    #toplevel_page_vcv-activation.vcv-go-premium .wp-submenu {
        padding-bottom: 0px !important;
    }

    #toplevel_page_vcv-settings.vcv-go-premium .wp-submenu li:last-child,
    #toplevel_page_vcv-activation.vcv-go-premium .wp-submenu li:last-child {
        padding-bottom: 7px;
    }

   .admin-color-fresh #toplevel_page_vcv-activation.vcv-go-premium .wp-submenu li:last-child a, .admin-color-fresh #toplevel_page_vcv-settings.vcv-go-premium .wp-submenu li:last-child a{
       color: #46AFEF;
   }

   .vcv-plugins-go-premium {
       color: #6dab3c;
       font-weight: bold;
   }
</style>
