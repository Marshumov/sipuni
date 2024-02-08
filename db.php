<?php
require "libs/rb-postgres.php";
R::setup('pgsql:host=localhost;dbname=admin_sipuni','admin_sipuni_manti','4BXjKb5FD6KXdUJb');
session_start([
    'cookie_lifetime' => 604800
]);
//session_write_close();
?>
