<?php
include_once 'database.php';
$settings = $mysqli->query('SELECT * FROM settings WHERE id =1')->fetch_assoc();

if (count($settings)) {
    $app_name = $settings['app_name'];
    if ("" == $settings['admin_email']) {
        //Set email admin
        $admin_email = '';
    } else {
        $admin_email = $settings['admin_email'];
    }

} else {
    $app_name = 'Service App';
    //Set email admin

    $admin_email = '';

}
$config = [
    'app_name'     => $app_name,
    'lang'         => 'en',
    'dir'          => 'ltr',
    'admin_email'  => $admin_email,
    'app_url'      => 'http://127.0.0.1/project_php/',
    'admin_assets' => 'http://127.0.0.1/project_php/admin/template/assets/',
];