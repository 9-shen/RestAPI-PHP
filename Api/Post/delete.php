<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-headers: Access-Control-Allow-headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');



require_once ('../../Config/Database.php');
require_once ('../../Models/Post.php');

// init DB
$database = new Database();
$db = $database->connect();

// init blog post
$post = new Post($db);

// Get The raw posted data
$data = json_decode(file_get_contents("PHP://input"));

// Set ID to Update
$post->id = $data->id;



if ($post->delete()) {
 print json_encode(
   array(
     'Messages' => 'Post Deleted'
   )
 );
}else {
  print json_encode(
    array(
      'Messages' => 'Post Not Deleted'
    )
  );
}
