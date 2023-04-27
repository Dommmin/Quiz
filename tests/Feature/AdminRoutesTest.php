<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanAndOthersCannotAccessQuestionsPage()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('questions.index'));

        $response->assertOk();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('questions.index'));

        $response->assertForbidden();

        $response = $this->get(route('questions.index'));

        $response->assertForbidden();
    }

    public function testAdminCanAndOthersCannotAccessQuizzesPage()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('quizzes.index'));

        $response->assertOk();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('quizzes.index'));

        $response->assertForbidden();

        $response = $this->get(route('quizzes.index'));

        $response->assertForbidden();
    }

    public function testAdminCanAndOthersCannotAccessTestsPage()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('tests'));

        $response->assertOk();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tests'));

        $response->assertForbidden();

        $response = $this->get(route('tests'));

        $response->assertForbidden();
    }
}
