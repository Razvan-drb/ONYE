<?php

// 1. connecting to DB

$pdoOnye = new PDO(
            'mysql:host=localhost;
            dbname=onye',
            'root',
            'root',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

        )
    );
    // 2. starting a session
    session_start();

    //3 . a variableto show the messages(error or success)
    $contenu = '';
    /* this variable will be exclusively used to show the errors and the success messages, we leave it empty and concatenate it with:  .=  to show the messages*/
    

    //4. including the functions.php file

    require_once 'functions.inc.php';
    
$mysqliOnye = new mysqli('localhost', 'root', 'root', 'onye');

if ($mysqliOnye->connect_error) {
    die('Connect Error (' . $mysqliOnye->connect_errno . ') ' . $mysqliOnye->connect_error);
}

// set character set to utf8
if (!$mysqliOnye->set_charset('utf8')) {
    die('Error loading character set utf8: ' . $mysqliOnye->error);
}