<?php

namespace Tadcms\Tests\Unit;

use Tests\TestCase;
use Tadcms\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var PostService $postService
     * */
    protected $postService;
    
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    
        $this->postService = app(PostService::class)->make();
    }
    
    public function testPostCreate()
    {
        // Try calling our method as part of the test
        $factory = factory(\Tadcms\Models\Post::class)->make();
        
        $result = $this->postService->create($factory->getAttributes());
    
        // Do some check to see that the result we got is what we expected
        $this->assertEquals($factory->title, $result->title);
    }
    
    public function testPostUpdate() {
        $factory = factory(\Tadcms\Models\Post::class)->create();
        $factory2 = factory(\Tadcms\Models\Post::class)->make();
        
        $result = $this->postService->update($factory->id,
            $factory2->getAttributes());
    
        $this->assertEquals($result->title, $factory2->title);
    }
    
    public function testDeletePost() {
        $factory = factory(\Tadcms\Models\Post::class)->create();
        $result = $this->postService->delete($factory->id);
        
        $this->assertTrue($result);
    }
    
    public function testPostCreateWithTaxonomies() {
        $data = [
            'title' => 'Test post',
            'content' => 'Post content',
            'type' => 'posts',
            'created_by' => 1,
            'updated_by' => 1,
            'status' => 'publish',
            'categories' => [1, 2, 3],
        ];
    
        $result = $this->postService->create($data);
    
        $this->assertEquals('Test post', $result->title);
    }
}