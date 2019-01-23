<?php

namespace Zbiller\Sort\Tests;

use Zbiller\Sort\Tests\Models\Post;

class IsSortableTest extends TestCase
{
    /** @test */
    public function it_sorts_model_records_in_ascending_order()
    {
        $this->makeModels();

        $data = [
            'sort' => 'name',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name z', $posts->last()->name);

        $data = [
            'sort' => 'views',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name y', $posts->last()->name);
    }

    /** @test */
    public function it_sorts_model_records_in_descending_order()
    {
        $this->makeModels();

        $data = [
            'sort' => 'name',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name z', $posts->first()->name);
        $this->assertEquals('Post name a', $posts->last()->name);

        $data = [
            'sort' => 'views',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name y', $posts->first()->name);
        $this->assertEquals('Post name a', $posts->last()->name);
    }

    /** @test */
    public function it_sorts_model_records_in_ascending_order_by_a_belongs_to_relation()
    {
        $this->makeModels();

        $data = [
            'sort' => 'author.name',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name y', $posts->last()->name);

        $data = [
            'sort' => 'author.age',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name y', $posts->last()->name);
    }

    /** @test */
    public function it_sorts_model_records_in_descending_order_by_a_belongs_to_relation()
    {
        $this->makeModels();

        $data = [
            'sort' => 'author.name',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name b', $posts->first()->name);
        $this->assertEquals('Post name z', $posts->last()->name);

        $data = [
            'sort' => 'author.age',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name b', $posts->first()->name);
        $this->assertEquals('Post name z', $posts->last()->name);
    }

    /** @test */
    public function it_sorts_model_records_in_ascending_order_by_a_has_one_relation()
    {
        $this->makeModels();

        $data = [
            'sort' => 'review.name',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name y', $posts->last()->name);

        $data = [
            'sort' => 'review.rating',
            'direction' => 'asc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name y', $posts->first()->name);
        $this->assertEquals('Post name a', $posts->last()->name);
    }

    /** @test */
    public function it_sorts_model_records_in_descending_order_by_a_has_one_relation()
    {
        $this->makeModels();

        $data = [
            'sort' => 'review.name',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name y', $posts->first()->name);
        $this->assertEquals('Post name a', $posts->last()->name);

        $data = [
            'sort' => 'review.rating',
            'direction' => 'desc',
        ];

        $posts = Post::sorted($data)->get();

        $this->assertEquals('Post name a', $posts->first()->name);
        $this->assertEquals('Post name y', $posts->last()->name);
    }
}
