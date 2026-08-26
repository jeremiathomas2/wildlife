<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Review;
use App\Models\AdminUser;

class ReviewModerationTest extends TestCase
{
    use RefreshDatabase;

    private function loginAdmin(): void
    {
        $admin = AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $this->session([
            'admin_logged_in' => true,
            'admin_user_id' => $admin->id,
            'admin_last_activity' => time(),
        ]);
    }

    private function createReview(array $overrides = []): Review
    {
        return Review::create(array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'tour' => 'Serengeti Safari',
            'rating' => 5,
            'text' => 'Great experience!',
            'status' => 'Pending',
        ], $overrides));
    }

    public function test_publish_review(): void
    {
        $this->loginAdmin();
        $review = $this->createReview();

        $response = $this->put(route('admin.reviews.update', [$review->id, 'Published']));
        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'status' => 'Published',
        ]);
    }

    public function test_reject_review(): void
    {
        $this->loginAdmin();
        $review = $this->createReview();

        $response = $this->put(route('admin.reviews.update', [$review->id, 'Rejected']));
        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'status' => 'Rejected',
        ]);
    }

    public function test_delete_review(): void
    {
        $this->loginAdmin();
        $review = $this->createReview();

        $response = $this->delete(route('admin.reviews.destroy', $review->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
