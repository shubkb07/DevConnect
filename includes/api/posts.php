<?php

register_api_route('dc', 'posts', 'get', 'post_get', array());

function post_get() {
    echo json_encode(
        array(
            'mow'=>'sf',
            'mow2'=>'sf2',
        )
        );
}
