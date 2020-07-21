<?php


namespace App\Business;

use App\Entity\Post;
use App\Entity\Topic;

interface TopicBusinessInterface {
    /**
     * @return Topic[]
     */
    function getTopics(int $page = 1, int $nbTopic = 25):array;
    function addTopic(string $title, Post $post):int;
    function getTopic(int $id, int $page = 1):Topic;
}