<?php

namespace Crimsoncircle\Model;

use PDO;

class Comment
{
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=db;dbname=blog", 'root', 'crimsoncircle');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }


    /**
     *
     * Validate params have data
     *
     * @param $postId
     * @param $content
     * @param $author
     * @return bool
     */
    public function validateParams($postId, $content, $author){
        $continue = true;
        if(empty($postId)){
            $continue = false;
        }
        if(empty($content)){
            $continue = false;
        }
        if(empty($author)){
            $continue = false;
        }

        return $continue;
    }

    /**
     *
     * store new record
     *
     * @param int $postId
     * @param string $content
     * @param string $author
     * @return mixed|null
     */
    public function store(int $postId, string $content, string $author)
    {
        $response = null;
        $actualDatetime = date('Y-m-d H:i:s');

        $query = $this->pdo->prepare("INSERT INTO comments (post_id, content, author, created_at, updated_at) VALUES (:post_id,:content,:author,:created_at,:updated_at)");
        $query->bindParam(":post_id", $postId);
        $query->bindParam(":content", $content);
        $query->bindParam(":author", $author);
        $query->bindParam(":created_at", $actualDatetime);
        $query->bindParam(":updated_at", $actualDatetime);

        // Excecute
        if($query->execute()){
            $response = $this->getById($this->pdo->lastInsertId());
        }

        return $response;
    }

    /**
     *
     * get comment by id
     *
     * @param int $id
     * @return mixed|null
     */
    public function getById(int $id){
        $response = null;
        $query = $this->pdo->prepare("SELECT id, post_id, content, author, created_at, updated_at FROM comments WHERE id = ".$id);
        if($query->execute()){
            $response = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $response;
    }

    /**
     *
     * get post by id
     *
     * @param int $postId
     * @param $page
     * @param $size
     * @return array|false|null
     */
    public function getByPostId(int $postId, $page=1, $size=10){
        $start = ($page-1) * 10;

        $response = null;
        $query = $this->pdo->prepare("SELECT id, post_id, content, author, created_at, updated_at FROM comments WHERE post_id = ".$postId." LIMIT ".$start."," .$size);
        if($query->execute()){
            $response = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $response;
    }

    /**
     *
     * delete comment by id
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id){
        $status = $this->pdo->exec("DELETE FROM comments WHERE id='".$id."'");

        return ($status) ? true : false;
    }
}