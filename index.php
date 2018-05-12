<?php
require_once('bootstrap/init.php');

Yov_init::getInstance()->init();

Yov_Router::getInstance()->run();
