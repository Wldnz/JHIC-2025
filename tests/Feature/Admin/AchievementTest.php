<?php

namespace Tests\Feature\Admin;

use App\Models\Achievement;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user and authenticate
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->adminUser);

        // Mock AlertDataGenerator and CloudinaryUtils
        $this->mock(AlertDataGenerator::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('uploadImageFile')->andReturn('http://example.com/uploaded_image.jpg');
            $mock->shouldReceive('getPublicIdByCloudinaryUrl')->andReturn('public_id');
            $mock->shouldReceive('replaceImageFile')->andReturn('http://example.com/new_uploaded_image.jpg');
            $mock->shouldReceive('deleteImageFile')->andReturn(true);
        });
    }

    /** @test */
    public function it_can_display_the_achievement_index_page()
    {
        $response = $this->get(route('admin.achievement'));
        $response->assertOk();
        $response->assertViewIs('admin.achievement.index');
        $response->assertViewHas('achievements');
    }

    /** @test */
    public function it_can_filter_achievements_by_search_query()
    {
        Achievement::factory()->create(['student_name' => 'John Doe', 'student_class' => '10A', 'student_major_name' => 'Science']);
        Achievement::factory()->create(['student_name' => 'Jane Smith', 'student_class' => '11B', 'student_major_name' => 'Art']);

        $response = $this->get(route('admin.achievement', ['search' => 'John']));
        $response->assertOk();
        $response->assertViewHas('achievements', function ($achievements) {
            return $achievements->count() === 1 && $achievements->first()->student_name === 'John Doe';
        });
    }

    /** @test */
    public function it_can_filter_achievements_by_major_id()
    {
        $major1 = Major::factory()->create();
        $major2 = Major::factory()->create();

        Achievement::factory()->create(['student_major_id' => $major1->id]);
        Achievement::factory()->create(['student_major_id' => $major2->id]);

        $response = $this->get(route('admin.achievement', ['major_id' => $major1->id]));
        $response->assertOk();
        $response->assertViewHas('achievements', function ($achievements) use ($major1) {
            return $achievements->count() === 1 && $achievements->first()->student_major_id === $major1->id;
        });
    }

    /** @test */
    public function it_can_display_the_create_achievement_page()
    {
        $response = $this->get(route('admin.achievement.create'));
        $response->assertOk();
        $response->assertViewIs('admin.achievement.create');
        $response->assertViewHasAll(['students', 'competitionPositions', 'competitionLevels']);
    }

    /** @test */
    public function it_can_store_a_new_achievement()
    {
        $student = Student::factory()->create();
        $major = Major::factory()->create();

        $data = [
            'student_nis' => $student->nis,
            'competition_position' => 'grade_1',
            'competition_name' => 'National Math Olympiad',
            'competition_level' => 'national',
            'won_at' => '2023-01-15',
            'image_file' => UploadedFile::fake()->image('achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.store'), $data);

        $response->assertRedirect(route('admin.achievement'));
        $this->assertDatabaseHas('achievements', [
            'student_nis' => $student->nis,
            'competition_name' => 'National Math Olympiad',
            'thumbnail_url' => 'http://example.com/uploaded_image.jpg',
        ]);
    }

    /** @test */
    public function it_returns_back_with_input_if_student_not_found_on_store()
    {
        $data = [
            'student_nis' => 'nonexistent_nis',
            'competition_position' => 'grade_1',
            'competition_name' => 'National Math Olympiad',
            'competition_level' => 'national',
            'won_at' => '2023-01-15',
            'image_file' => UploadedFile::fake()->image('achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('student_nis');
        $this->assertDatabaseMissing('achievements', ['student_nis' => 'nonexistent_nis']);
    }

    /** @test */
    public function it_returns_back_with_input_if_image_upload_fails_on_store()
    {
        $student = Student::factory()->create();
        $major = Major::factory()->create();

        // Override the mock for this specific test to simulate upload failure
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('uploadImageFile')->andReturn(false);
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });

        $data = [
            'student_nis' => $student->nis,
            'competition_position' => 'grade_1',
            'competition_name' => 'National Math Olympiad',
            'competition_level' => 'national',
            'won_at' => '2023-01-15',
            'image_file' => UploadedFile::fake()->image('achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('student_nis');
        $this->assertDatabaseMissing('achievements', ['student_nis' => $student->nis]);
    }

    /** @test */
    public function it_handles_achievement_creation_failure()
    {
        $student = Student::factory()->create();
        $major = Major::factory()->create();

        // Mock Achievement model to simulate creation failure
        $this->mock(Achievement::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('create')->andReturn(false);
        });

        $data = [
            'student_nis' => $student->nis,
            'competition_position' => 'grade_1',
            'competition_name' => 'National Math Olympiad',
            'competition_level' => 'national',
            'won_at' => '2023-01-15',
            'image_file' => UploadedFile::fake()->image('achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('student_nis');
        $this->assertDatabaseMissing('achievements', ['student_nis' => $student->nis]);
    }

    /** @test */
    public function it_can_display_the_detail_achievement_page()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->get(route('admin.achievement.detail', $achievement));
        $response->assertOk();
        $response->assertViewIs('admin.achievement.detail');
        $response->assertViewHasAll(['achievement', 'students', 'competitionPositions', 'competitionLevels']);
        $response->assertViewHas('achievement', function ($viewAchievement) use ($achievement) {
            return $viewAchievement->id === $achievement->id;
        });
    }

    /** @test */
    public function it_can_update_an_achievement()
    {
        $achievement = Achievement::factory()->create();
        $newStudent = Student::factory()->create();

        $data = [
            'student_nis' => $newStudent->nis,
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'competition_level' => 'provincial',
            'won_at' => '2024-03-20',
            'image_file' => UploadedFile::fake()->image('new_achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.update', $achievement), $data);

        $response->assertRedirect(route('admin.achievement'));
        $this->assertDatabaseHas('achievements', [
            'id' => $achievement->id,
            'student_nis' => $newStudent->nis,
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'thumbnail_url' => 'http://example.com/new_uploaded_image.jpg',
        ]);
    }

    /** @test */
    public function it_returns_back_with_input_if_student_not_found_on_update()
    {
        $achievement = Achievement::factory()->create();

        $data = [
            'student_nis' => 'nonexistent_nis',
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'competition_level' => 'provincial',
            'won_at' => '2024-03-20',
        ];

        $response = $this->post(route('admin.achievement.update', $achievement), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('student_nis');
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id, 'student_nis' => $achievement->student_nis]); // Ensure original student_nis is still there
    }

    /** @test */
    public function it_returns_back_if_old_image_public_id_not_found_on_update()
    {
        $achievement = Achievement::factory()->create();

        // Override the mock for this specific test to simulate public ID not found
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('getPublicIdByCloudinaryUrl')->andReturn(false);
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });

        $data = [
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'competition_level' => 'provincial',
            'won_at' => '2024-03-20',
            'image_file' => UploadedFile::fake()->image('new_achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.update', $achievement), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('competition_position'); // Should retain input
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id, 'competition_position' => $achievement->competition_position]); // Ensure original data is still there
    }

    /** @test */
    public function it_returns_back_if_new_image_upload_fails_on_update()
    {
        $achievement = Achievement::factory()->create();

        // Override the mock for this specific test to simulate upload failure
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('getPublicIdByCloudinaryUrl')->andReturn('public_id');
            $mock->shouldReceive('replaceImageFile')->andReturn(false);
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });

        $data = [
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'competition_level' => 'provincial',
            'won_at' => '2024-03-20',
            'image_file' => UploadedFile::fake()->image('new_achievement.jpg'),
        ];

        $response = $this->post(route('admin.achievement.update', $achievement), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('competition_position'); // Should retain input
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id, 'competition_position' => $achievement->competition_position]); // Ensure original data is still there
    }

    /** @test */
    public function it_handles_achievement_update_failure()
    {
        $achievement = Achievement::factory()->create();
        $originalCompetitionName = $achievement->competition_name;

        // Mock the save method to return false
        $this->mock(Achievement::class, function (Mockery\MockInterface $mock) use ($achievement) {
            $mock->shouldReceive('find')->andReturn($achievement); // For the controller to find the achievement
            $mock->shouldReceive('save')->andReturn(false);
        });

        $data = [
            'competition_position' => 'grade_2',
            'competition_name' => 'Regional Science Fair',
            'competition_level' => 'provincial',
            'won_at' => '2024-03-20',
        ];

        $response = $this->post(route('admin.achievement.update', $achievement), $data);

        $response->assertRedirect();
        $response->assertSessionHasInput('competition_position');
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id, 'competition_name' => $originalCompetitionName]); // Ensure original data is still there
    }

    /** @test */
    public function it_can_delete_an_achievement()
    {
        $achievement = Achievement::factory()->create();

        $response = $this->delete(route('admin.achievement.delete', $achievement));

        $response->assertRedirect(route('admin.achievement'));
        $this->assertDatabaseMissing('achievements', ['id' => $achievement->id]);
    }

    /** @test */
    public function it_returns_back_if_image_public_id_not_found_on_delete()
    {
        $achievement = Achievement::factory()->create();

        // Override the mock for this specific test to simulate public ID not found
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('getPublicIdByCloudinaryUrl')->andReturn(false);
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });

        $response = $this->delete(route('admin.achievement.delete', $achievement));

        $response->assertRedirect();
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id]); // Ensure achievement is not deleted
    }

    /** @test */
    public function it_returns_back_if_image_deletion_fails()
    {
        $achievement = Achievement::factory()->create();

        // Override the mock for this specific test to simulate image deletion failure
        $this->mock(CloudinaryUtils::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('getPublicIdByCloudinaryUrl')->andReturn('public_id');
            $mock->shouldReceive('deleteImageFile')->andReturn(false);
            $mock->shouldReceive('generateAsFlashToSession')->andReturnNull();
        });

        $response = $this->delete(route('admin.achievement.delete', $achievement));

        $response->assertRedirect();
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id]); // Ensure achievement is not deleted
    }

    /** @test */
    public function it_handles_achievement_deletion_failure()
    {
        $achievement = Achievement::factory()->create();

        // Mock the delete method to return false
        $this->mock(Achievement::class, function (Mockery\MockInterface $mock) use ($achievement) {
            $mock->shouldReceive('find')->andReturn($achievement); // For the controller to find the achievement
            $mock->shouldReceive('delete')->andReturn(false);
        });

        $response = $this->delete(route('admin.achievement.delete', $achievement));

        $response->assertRedirect();
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id]); // Ensure achievement is not deleted
    }
}
