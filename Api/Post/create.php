<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// Check Of data Submited
// print json_encode(
//   array(
//     $post->title = $data->title,
//     $post->body = $data->body,
//     $post->author = $data->author,
//     $post->category_id = $data->category_id,
//   )
// );


if ($post->create()) {
 print json_encode(
   array(
     'Messages' => 'Post Created'
   )
 );
}else {
  print json_encode(
    array(
      'Messages' => 'Post Not Created'
    )
  );
}
