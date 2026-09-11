<?php

namespace Tests\Feature;

use App\Mail\ContactSubmittedMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_is_saved_and_email_is_sent(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'fullname' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone' => '0909090909',
            'password' => bcrypt('password123'),
            'admin_role' => User::ROLE_CLIENT,
        ]);

        $this->actingAs($user);

        $response = $this->actingAs($user)->from('/lien-he')->post('/lien-he', [
            'phone' => '0909090909',
            'message' => 'Muốn hỏi về lịch cắt tóc cho tuần sau.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Cảm ơn bạn đã liên hệ! Tiệm sẽ phản hồi sớm nhất có thể.');

        $this->get('/lien-he')
            ->assertOk()
            ->assertSee('Cảm ơn bạn đã liên hệ! Tiệm sẽ phản hồi sớm nhất có thể.');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone' => '0909090909',
        ]);

        Mail::assertSent(ContactSubmittedMail::class);
    }
}
