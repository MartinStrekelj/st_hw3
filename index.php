<?php

session_start();

require_once("controller/UserController.php");
require_once("controller/RouteController.php");
require_once("controller/MatchController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [

    "index" => function(){
        RouteController::index();
    },

    "fields" => function() {
        RouteController::showFields();
    },

    "login" => function (){
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            UserController::login();
        }else{
            UserController::showLoginForm();
        }
    },

    "" => function () {
        ViewHelper::redirect(BASE_URL . "index");
    },

    "registration" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::register();
        } else{
            UserController::showRegistrationForm();
        }
    },

    "add-match" => function() {
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            MatchController::addMatch();
        }else{
            MatchController::showAddForm();
        }
    },

    "players" => function() {
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        RouteController::showPlayers();
    },
    "display_match" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        MatchController::displayUserMatches();
    },

    "logout" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        UserController::logout();
    },

    "edit-profile" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            UserController::editProfile();
        }else{
            UserController::showEditForm();
        }
    },

    "delete-user" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            UserController::deleteUser();
        }
    },
    
    "api/searchUser" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        UserController::searchApi();
    },

    "api/addUpvote" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        MatchController::addUpvote();
    },

    "api/removeUpvote" => function (){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        MatchController::removeUpvote();
    },

    "edit-match" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            MatchController::editMatch();
        }else{
            MatchController::showEditMatchForm();
        }
    },
    
    "delete-match" => function(){
        if (!SkalcaDB::userLoggedIn()){
            throw new Exception("Login required.");
        }
        MatchController::deleteMatch();
    }

];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 