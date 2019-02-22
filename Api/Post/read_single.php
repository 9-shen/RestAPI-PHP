<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


require_once ('../../Config/Database.php');
require_once ('../../Models/Post.php');

// init DB
$database = new Database();
$db = $database->connect();

// init blog post
$post = new Post($db);

// Get id
$post->id = isset($_GET['id']) ? $_GET['id'] : die();


// Get Data
$post->read_single();

// Set data to array
$post_arr = array(

  'id' => $post->id,
  'title' => $post->title,
  'body' => $post->body,
  'author' => $post->author,
  'category_id' => $post->category_id,
  'category_name' => $post->category_name

);

// Turn Data to Json

print_r(json_encode($post_arr));
