<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../includes/initialize.php';
header("Location: " . WEB_ROOT . '#!' . $_GET['_escaped_fragment_'] , TRUE, 301);
require_once '../includes/teardown.php';