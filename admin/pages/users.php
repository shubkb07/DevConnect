<?php
add_menu('users', 'Users', array('callback'=>'page_users'));
add_sub_menu('all', 'All Users', 'users', array('callback'=>'all_users'));
add_sub_menu('edit', 'Edit User', 'users', array('callback'=>'edit_user'));


function page_users() {}

function page_users_submit() {}

function all_users() {}

function all_users_submit1() {}

function edit_user() {}

function edit_user_submit1() {}