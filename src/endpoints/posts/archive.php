<?php

	$app->get('/posts/', function( $req, $res, $args) {
        $res->write(
            json_encode(
                array(
                    'id' => 1
                )
            )
        );
    });