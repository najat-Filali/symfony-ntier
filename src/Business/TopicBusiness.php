<?php

namespace App\Business;

use App\Entity\Post;
use App\Entity\Topic;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TopicBusiness implements TopicBusinessInterface {
    /**
     * @var {PostRepository}
     */
    private PostRepository $repoPost;
    private TopicRepository $repoTopic;
    private EntityManagerInterface $manager;
    private PostBusinessInterface $postBusiness;

    public function __construct(PostRepository $repoPost, TopicRepository $repoTopic, EntityManagerInterface $manager, PostBusinessInterface $postBusiness) {
        $this->repoPost = $repoPost;
        $this->repoTopic = $repoTopic;
        $this->manager = $manager;
        $this->postBusiness = $postBusiness;
    }
    public function getTopic(int $id, int $page = 1): Topic
    {
        
        $topic = $this->repoTopic->find($id);
        if(!$topic){
            throw new NotFoundResourceException("Topic Not Found");
        }
        
        $posts = $this->repoPost->findBy([], [], 25, ($page-1)*25);
        $topic->setPosts($posts);
        return $topic;

    }

    public function getTopics(int $page = 1, int $nbTopic = 25): array
    {
        return $this->repoTopic->findBy([], [], $nbTopic, ($page-1)*$nbTopic);
    }

    public function addTopic(string $title, Post $post): int
    {
        $topic = new Topic();
        $topic->setTitle($title);
        $this->manager->persist($topic);
        $this->manager->flush();
        $this->postBusiness->addPost($post, $topic->getId());
        return $topic->getId();
    }

}