<?php
add_menu('posts', 'Posts', array('callback'=>'page_posts'));
add_sub_menu('all', 'All Posts', 'posts', array('callback'=>'all_posts'));
add_sub_menu('edit', 'Edit Post', 'posts', array('callback'=>'edit_post'));


function page_posts() {}

function page_posts_submit() {}

function all_posts() {}

function all_posts_submit1() {}

function edit_post() {}

function edit_post_submit1() {}