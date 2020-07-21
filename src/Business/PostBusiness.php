<?php

namespace App\Business;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Postbusiness implements PostBusinessInterface {
    /**
     * @var {PostRepository}
     */
    private PostRepository $repoPost;
    private TopicRepository $repoTopic;
    private EntityManagerInterface $manager;

    public function __construct(PostRepository $repoPost, TopicRepository $repoTopic, EntityManagerInterface $manager) {
        $this->repoPost = $repoPost;
        $this->repoTopic = $repoTopic;
        $this->manager = $manager;
    }

    public function updatePostContent(int $idPost, string $content)
    {
        $post = $this->repoPost->find($idPost);
        if(!$post) {
            throw new NotFoundResourceException("Post Not Found");
        }
        $post->setContent($content);
        $post->setLastUpdate(new \DateTime());
        $this->manager->flush();
        
    }

    public function addPost(Post $post, int $idTopic): int
    {
        $topic = $this->repoTopic->find($idTopic);
        if(!$topic){
            throw new NotFoundResourceException("Topic Not Found");
        }
        $post->setDate(new \DateTime());
        $post->setTopic($topic);
        $this->manager->persist($post);
        $this->manager->flush();
        return $post->getId();
    }
}