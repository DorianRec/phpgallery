<?php

require_once __DIR__ . '/Core/autoload.php';

/*require_once(__DIR__ . '/' .
    App::load(
        URLParser::treeSearch(
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
        )));*/
App::load(URLParser::findLastSetup(URLBuilder::get_url()));
