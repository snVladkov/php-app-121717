<?php

function debug($data, $die = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($die) {
        die;
    }
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}