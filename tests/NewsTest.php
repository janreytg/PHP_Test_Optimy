<?php

namespace App\Tests;

use App\Models\Comment;
use App\Models\News;
use Faker\Factory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class NewsTest extends TestCase
{
    protected $faker;
    protected $news;
    public function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();

        $this->news = new News();

        $preloadedTitle = $faker->name();
        $preloadedBody = $faker->text();

        $this->news->addNews([
            'title' => $preloadedTitle,
            'body' => $preloadedBody
        ]);
    }

    #[Test]
    public function it_can_create_a_news()
    {
        $faker = Factory::create();

        $data = [
            'title' => $faker->name(),
            'text' => $faker->text(20)
        ];

        $id = $this->news->addNews($data);
        $news = $this->news->findById($id);

        $result = $this->news->getAll();

        $this->assertContains($news, $result);
    }

    #[Test]
    public function it_can_create_a_news_comments()
    {
        $faker = Factory::create();

        $data = [
            'title' => $faker->name(),
            'text' => $faker->text(20)
        ];

        $commentData = [
            'body' => '[Test]Lorem ipsum'
        ];

        $id = $this->news->addNews($data, $commentData);
        $news = $this->news->findById($id);

        $comment = $this->news->comments($news, new Comment);

        $this->assertEquals($commentData['body'], $comment[0]['body']);
    }

    #[Test]
    public function it_can_delete_a_news_and_all_associated_comments()
    {
        $faker = Factory::create();

        $data = [
            'title' => $faker->name(),
            'text' => $faker->text(20)
        ];

        $commentData = [
            'body' => '[Test]Lorem ipsum'
        ];

        $id = $this->news->addNews($data, $commentData);
        $news = $this->news->findById($id);

        $comment = $this->news->comments($news, new Comment);
        $commentIds = array_column($comment, 'id');

        (new Comment)->deleteComments($commentIds);
        $this->news->deleteNews($id);


        $this->assertEmpty($this->news->comments($news, new Comment));
        $this->assertFalse($this->news->findById($id));
    }

}