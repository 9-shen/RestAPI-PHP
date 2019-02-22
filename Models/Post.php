<?php

class Post{

  private $conn;
  private $table = 'posts';
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;


  public function __construct($db){

    $this->conn = $db;

  }

// Read all data
  public function read(){


    $query = "SELECT
          c.name as category_name,
          p.id,
          p.category_id,
          p.title,
          p.body,
          p.author,
          p.created_at
        FROM
         $this->table  p
        LEFT JOIN
          categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC ";

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;


  }


// read signle data

  public function read_single(){

    $query = "SELECT
          c.name as category_name,
          p.id,
          p.category_id,
          p.title,
          p.body,
          p.author,
          p.created_at
        FROM
         $this->table  p
        LEFT JOIN
          categories c ON p.category_id = c.id
        WHERE p.id = ?  LIMIT 0,1";

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->title = $row['title'];
      $this->body = $row['body'];
      $this->author = $row['author'];
      $this->category_id = $row['category_id'];
      $this->category_name = $row['category_name'];



  }


// create post

public function create(){

  $query = "INSERT INTO $this->table
            SET
            title = ?,
            body = ?,
            author = ?,
            category_id = ? ";

  $stmt = $this->conn->prepare($query);

  // filter data
  $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
  $this->body = filter_var($this->body, FILTER_SANITIZE_STRING);
  $this->author = filter_var($this->author, FILTER_SANITIZE_STRING);
  $this->category_id = filter_var($this->category_id, FILTER_SANITIZE_NUMBER_INT);

  $stmt->bindParam(1, $this->title);
  $stmt->bindParam(2, $this->body);
  $stmt->bindParam(3, $this->author);
  $stmt->bindParam(4, $this->category_id);


  if ($stmt->execute()) {
    return true;
  }
  // print error is something goes wrong
  printf("Error: %s.\n", $stmt->error);
  return false;
}



// update post

public function update(){

  $query = "UPDATE $this->table
            SET
            title = ?,
            body = ?,
            author = ?,
            category_id = ?
            WHERE id = ?";

  $stmt = $this->conn->prepare($query);

  // filter data
  $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
  $this->body = filter_var($this->body, FILTER_SANITIZE_STRING);
  $this->author = filter_var($this->author, FILTER_SANITIZE_STRING);
  $this->category_id = filter_var($this->category_id, FILTER_SANITIZE_NUMBER_INT);
  $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

  $stmt->bindParam(1, $this->title);
  $stmt->bindParam(2, $this->body);
  $stmt->bindParam(3, $this->author);
  $stmt->bindParam(4, $this->category_id);
  $stmt->bindParam(5, $this->id);


  if ($stmt->execute()) {
    return true;
  }
  // print error is something goes wrong
  printf("Error: %s.\n", $stmt->error);
  return false;
}



// delete post
  public function delete(){

    $query = "DELETE FROM $this->table WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }
    // print error is something goes wrong
    printf("Error: %s.\n", $stmt->error);
    return false;
  }





// END CLASS
}
