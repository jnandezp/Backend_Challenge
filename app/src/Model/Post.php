<?php

namespace Crimsoncircle\Model;

use PDO;

class Post
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
     * @param $title
     * @param $content
     * @param $author
     * @param $slug
     * @return bool
     */
    public function validateParams($title, $content, $author, $slug){
        $continue = true;
        if(empty($title)){
            $continue = false;
        }
        if(empty($content)){
            $continue = false;
        }
        if(empty($author)){
            $continue = false;
        }
        if(empty($slug)){
            $continue = false;
        }

        return $continue;
    }

    /**
     *
     * store new record
     *
     * @param $title
     * @param $content
     * @param $author
     * @param $slug
     * @return bool
     */
    public function store(string $title, string $content, string $author, string $slug)
    {
        $response = null;
        $actualDatetime = date('Y-m-d H:i:s');

        $query = $this->pdo->prepare("INSERT INTO posts (title, content, author, slug, created_at, updated_at) VALUES (:title,:content,:author,:slug,:created_at,:updated_at)");
        $query->bindParam(":title", $title);
        $query->bindParam(":content", $content);
        $query->bindParam(":author", $author);
        $query->bindParam(":slug", $slug);
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
     * get post by id
     *
     * @param int $id
     * @return mixed|null
     */
    public function getById(int $id){
        $response = null;
        $query = $this->pdo->prepare("SELECT id, title, content, author, slug, created_at, updated_at FROM posts WHERE id = ".$id);
        if($query->execute()){
            $response = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $response;
    }

    /**
     * search by slug
     *
     * @param string $slug
     * @return mixed|null
     */
    public function search(string $slug)
    {
        $response = null;
        $query = $this->pdo->prepare("SELECT id,title, content, author, slug, created_at, updated_at FROM posts WHERE slug = :slug");
        $query->bindParam(":slug", $slug);

        if ($query->execute()) {
            $queryFetch = $query->fetch(PDO::FETCH_ASSOC);
            if (!empty($queryFetch)) {
                $response = $queryFetch;
            }
        }


        return $response;
    }

    /**
     *
     * deletepost by slug
     *
     * @param string $slug
     * @return bool
     */
    public function delete(string $slug){
        $status = $this->pdo->exec("DELETE FROM posts WHERE slug='".$slug."'");

        return ($status) ? true : false;
    }
}