<?php

namespace Zbiller\Sort\Tests;

use Zbiller\Sort\Tests\Models\Post;
use Zbiller\Sort\Tests\Models\Author;
use Zbiller\Sort\Tests\Models\Review;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Foundation\Application;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Set up the database and migrate the necessary tables.
     *
     * @param  $app
     */
    protected function setUpDatabase(Application $app)
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    /**
     * @return void
     */
    protected function makeModels()
    {
        $author1 = Author::create([
            'name' => 'Author name a',
            'age' => 10,
        ]);

        $author2 = Author::create([
            'name' => 'Author name z',
            'age' => 20,
        ]);

        $post1 = Post::create([
            'author_id' => $author1->id,
            'name' => 'Post name a',
            'views' => 10,
        ]);

        $post2 = Post::create([
            'author_id' => $author1->id,
            'name' => 'Post name z',
            'views' => 20,
        ]);

        $post3 = Post::create([
            'author_id' => $author2->id,
            'name' => 'Post name b',
            'views' => 30,
        ]);

        $post4 = Post::create([
            'author_id' => $author2->id,
            'name' => 'Post name y',
            'views' => 40,
        ]);

        $review1 = Review::create([
            'post_id' => $post1->id,
            'name' => 'Review a',
            'rating' => 4,
        ]);

        $review2 = Review::create([
            'post_id' => $post2->id,
            'name' => 'Review b',
            'rating' => 3,
        ]);

        $review3 = Review::create([
            'post_id' => $post3->id,
            'name' => 'Review c',
            'rating' => 2,
        ]);

        $review4 = Review::create([
            'post_id' => $post4->id,
            'name' => 'Review d',
            'rating' => 1,
        ]);
    }
}
