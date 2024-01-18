<?php
include_once "Parse.php";

$filename = "./Mobile_Food_Facility_Permit.csv";
$parse = new \Taco\Parse($filename);
$parse->getTaco();