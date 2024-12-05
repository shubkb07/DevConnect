<?php
add_menu('test', 'Test Page', array('callback'=>'page_test1'));
add_sub_menu('test1', 'Test 1 Page', 'test', array('callback'=>'page_test1'));

function page_test() {}

function page_test_submit() {}

function page_test1() {}

function page_test_submit1() {}