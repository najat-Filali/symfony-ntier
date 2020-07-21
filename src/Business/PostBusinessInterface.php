<?php


namespace App\Business;

use App\Entity\Post;

interface PostBusinessInterface {
    function addPost(Post $post, int $idTopic):int;
    function updatePostContent(int $idPost, string $content);
    // function postsByTopic(int $idTopic, int $page=1, int $nbPost=25):array;
}