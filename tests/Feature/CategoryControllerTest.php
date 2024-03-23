<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_categories()
    {
        $response = $this->get('/api/category/all');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => ['id', 'name', 'is_publish']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_get_category_detail()
    {
        $category = Category::factory()->create();

        $response = $this->get("/api/category/{$category->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => ['id', 'name', 'is_publish']
                 ]);
    }

    /** @test */
    public function it_can_insert_category()
    {
        $categoryData = Category::factory()->raw();

        $response = $this->post('/api/category', $categoryData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Successful category insert',
                 ]);
    }

    /** @test */
    public function it_can_update_category()
    {
        $category = Category::factory()->create();
        $updatedData = ['name' => 'Updated Name', 'is_publish' => false];

        $response = $this->put("/api/category/{$category->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Successful category update',
                 ]);
    }

    /** @test */
    public function it_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete("/api/category/{$category->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Successful category delete',
                 ]);
    }
}
