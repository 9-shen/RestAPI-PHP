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

// post query
$result = $post->read();

// get row count

$num = $result->rowCount();

// check if any posts
if ($num > 0) {

  // init array
  $posts_arr = array();
  $posts_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

    extract($row);

    $post_item = array(

      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name

    );

    // push to data array

    array_push($posts_arr['data'], $post_item);

  }

  // turn data to json

  print json_encode($posts_arr);


}else {
  print json_encode(
    array(
      'Message => No Posts'
    )
  );
}
