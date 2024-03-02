<?php
require "libs/rb-postgres.php";
R::setup('pgsql:host=localhost;dbname=admin_sipuni','admin_sipuni_manti','4B1XjKb5FD6KXdUJ4b');
session_start([
    'cookie_lifetime' => 604800
]);
//session_write_close();
?>
