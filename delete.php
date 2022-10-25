<?php

// Importa as configurações do aplicativo:
require('includes/config.php');

// Obtém o ID a ser apagado da QUERY STRING:
$id = $_SERVER['QUERY_STRING'];

debug($id);
