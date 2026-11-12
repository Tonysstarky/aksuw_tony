<?php

namespace Tests\Feature;

use App\Mail\PasswordResetCodeMail;
use App\Mail\VerificationCodeMail;
use App\Models\Category;
use App\Models\Order;
use App\Models\Question;
use App\Models\User;
use App\Models\Water;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WaterFactoryTest extends TestCase
{
    use RefreshDatabase;

    private function makeWater(int $stock = 100, float $price = 2.50): Water
    {
        $category = Category::create([
            'name_tm' => 'Teşne',
            'name_ru' => 'Тешне',
            'name_en' => 'Teshne',
        ]);

        return Water::create([
            'category_id' => $category->id,
            'name' => 'Teşne Çeşme Suwy 0.5L',
            'volume' => '0.5L',
            'price' => $price,
            'stock' => $stock,
            'ph_level' => '7.4',
        ]);
    }

    public function test_home_page_can_be_rendered(): void
    {
        $this->get('/')->assertOk()->assertSee('Yusup Gajaýew');
    }

    public function test_three_languages_switching_works(): void
    {
        foreach (['ru', 'en', 'tm'] as $locale) {
            $this->get('/lang/'.$locale)->assertSessionHas('locale', $locale);
        }

        $this->withSession(['locale' => 'ru'])->get('/')->assertSee('Главная');
        $this->withSession(['locale' => 'en'])->get('/')->assertSee('Home');
        $this->withSession(['locale' => 'tm'])->get('/')->assertSee('Baş sahypa');
    }

    public function test_guests_cannot_access_protected_pages(): void
    {
        $this->get('/waters')->assertRedirect('/login');
        $this->get('/categories')->assertRedirect('/login');
        $this->get('/questions/ask')->assertRedirect('/login');
        $this->get('/my-questions')->assertRedirect('/login');
        $this->get('/orders')->assertRedirect('/login');
    }

    public function test_user_can_register_directly_and_login_later(): void
    {
        $this->post('/register', [
            'name' => 'Yusup Gajaýew',
            'email' => 'yusup_test@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->assertNotNull(User::where('email', 'yusup_test@gmail.com')->first()->email_verified_at);

        // Çykyş edip, täzeden adaty login
        $this->post('/logout');
        $this->assertGuest();

        $this->post('/login', [
            'email' => 'yusup_test@gmail.com',
            'password' => 'password123',
        ])->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_register_rejects_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@gmail.com']);

        $this->post('/register', [
            'name' => 'Täze Ulanyjy',
            'email' => 'taken@gmail.com',
            'password' => 'newpassword1',
            'password_confirmation' => 'newpassword1',
        ])->assertSessionHasErrors('email');
    }

    public function test_forgot_password_sends_gmail_code_and_resets_password(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'atagapy@gmail.com',
            'password' => Hash::make('oldpassword123'),
        ]);

        $this->post('/forgot-password', ['email' => 'atagapy@gmail.com'])
            ->assertRedirect('/verify-code');

        $code = null;
        Mail::assertSent(PasswordResetCodeMail::class, function (PasswordResetCodeMail $mail) use (&$code) {
            $code = $mail->code;
            return $mail->hasTo('atagapy@gmail.com');
        });

        // 6 belgili kod bilen täze parol goýulýar
        $this->post('/verify-code', [
            'email' => 'atagapy@gmail.com',
            'code' => $code,
            'password' => 'brandnewpass123',
            'password_confirmation' => 'brandnewpass123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->assertTrue(Hash::check('brandnewpass123', $user->fresh()->password));
    }

    public function test_register_rejects_verified_email_and_does_not_overwrite_password(): void
    {
        Mail::fake();
        $user = User::factory()->create(['email' => 'taken@gmail.com', 'password' => Hash::make('original123')]);

        $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'taken@gmail.com',
            'password' => 'newpassword1',
            'password_confirmation' => 'newpassword1',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('original123', $user->fresh()->password));
        Mail::assertNothingSent();
    }

    public function test_user_can_update_profile_and_change_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword1')]);

        $this->actingAs($user)->get('/profile')->assertOk();

        $this->actingAs($user)->put('/profile', [
            'name' => 'Täze Ady',
            'phone' => '+993 65 000000',
            'address' => 'Aşgabat ş.',
        ])->assertRedirect('/profile');
        $this->assertEquals('Täze Ady', $user->fresh()->name);

        // Ýalňyş häzirki parol
        $this->actingAs($user)->post('/change-password', [
            'current_password' => 'wrong',
            'password' => 'brandnew123',
            'password_confirmation' => 'brandnew123',
        ])->assertSessionHasErrors('current_password');

        // Dogry häzirki parol
        $this->actingAs($user)->post('/change-password', [
            'current_password' => 'oldpassword1',
            'password' => 'brandnew123',
            'password_confirmation' => 'brandnew123',
        ])->assertRedirect('/profile');
        $this->assertTrue(Hash::check('brandnew123', $user->fresh()->password));
    }

    public function test_regular_user_cannot_manage_waters_but_admin_can(): void
    {
        $water = $this->makeWater();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($user)->get('/waters')->assertOk()->assertSee('Teşne Çeşme Suwy 0.5L');
        $this->actingAs($user)->delete("/water/{$water->id}")->assertForbidden();
        $this->assertDatabaseHas('waters', ['id' => $water->id]);

        $this->actingAs($admin)->delete("/water/{$water->id}")->assertRedirect('/waters');
        $this->assertDatabaseMissing('waters', ['id' => $water->id]);
    }

    public function test_admin_can_create_water_with_validation(): void
    {
        $admin = User::factory()->admin()->create();
        $water = $this->makeWater();

        $this->actingAs($admin)->post('/water/store', [])->assertSessionHasErrors(['name', 'category_id', 'volume', 'price', 'stock']);

        $this->actingAs($admin)->post('/water/store', [
            'category_id' => $water->category_id,
            'name' => 'Täze Suw 1.5L',
            'volume' => '1.5L',
            'price' => 4.5,
            'stock' => 20,
        ])->assertRedirect('/waters');

        $this->assertDatabaseHas('waters', ['name' => 'Täze Suw 1.5L']);
    }

    public function test_password_reset_with_emailed_code(): void
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'reset@gmail.com', 'password' => Hash::make('oldpassword1')]);

        $this->post('/forgot-password', ['email' => 'reset@gmail.com'])->assertRedirect('/verify-code');
        $this->assertDatabaseHas('password_reset_tokens', ['email' => 'reset@gmail.com']);

        $code = null;
        Mail::assertSent(PasswordResetCodeMail::class, function (PasswordResetCodeMail $mail) use (&$code) {
            $code = $mail->code;

            return $mail->hasTo('reset@gmail.com');
        });

        $this->post('/verify-code', [
            'email' => 'reset@gmail.com',
            'code' => $code,
            'password' => 'newpassword777',
            'password_confirmation' => 'newpassword777',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user->fresh());
        $this->assertTrue(Hash::check('newpassword777', $user->fresh()->password));
    }

    public function test_wrong_reset_code_is_rejected(): void
    {
        Mail::fake();
        $user = User::factory()->create(['email' => 'wrong@gmail.com']);

        $this->post('/forgot-password', ['email' => 'wrong@gmail.com']);

        $this->post('/verify-code', [
            'email' => 'wrong@gmail.com',
            'code' => '000000',
            'password' => 'newpassword777',
            'password_confirmation' => 'newpassword777',
        ])->assertSessionHasErrors('code');

        $this->assertGuest();
    }

    public function test_user_can_ask_question_and_only_admin_can_answer(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($user)->post('/questions', [
            'name' => 'Yusup',
            'email' => 'yusup@gmail.com',
            'subject' => 'Teşne suwunyň hili',
            'message' => 'Göwrümleri barmy?',
        ])->assertRedirect('/my-questions');

        $question = Question::first();
        $this->assertEquals($user->id, $question->user_id);

        $this->actingAs($user)->post("/questions/{$question->id}/answer", ['answer' => 'x'])->assertForbidden();

        $this->actingAs($admin)->post("/questions/{$question->id}/answer", ['answer' => 'Hawa, bar.'])
            ->assertRedirect('/admin/questions');

        $this->assertDatabaseHas('questions', ['id' => $question->id, 'answer' => 'Hawa, bar.', 'status' => 'answered']);
        $this->actingAs($user)->get('/my-questions')->assertSee('Hawa, bar.');
    }

    public function test_order_decreases_stock_and_user_can_cancel_only_own_pending_order(): void
    {
        $water = $this->makeWater(stock: 10, price: 3.00);
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)->post('/orders', [
            'water_id' => $water->id,
            'quantity' => 4,
            'delivery_address' => 'Aşgabat ş.',
            'phone' => '+993 65 112233',
        ])->assertRedirect('/orders');

        $order = Order::first();
        $this->assertEquals(6, $water->fresh()->stock);
        $this->assertEquals('12.00', $order->total_price);

        // başga ulanyjy ýatyryp bilmeýär
        $this->actingAs($other)->put("/orders/{$order->id}/status", ['status' => 'cancelled'])->assertForbidden();

        // eýesi ýatyryp biler, ammar yzyna gaýdýar
        $this->actingAs($user)->put("/orders/{$order->id}/status", ['status' => 'cancelled'])->assertRedirect('/orders');
        $this->assertEquals(10, $water->fresh()->stock);
    }

    public function test_cannot_order_more_than_stock(): void
    {
        $water = $this->makeWater(stock: 2);
        $user = User::factory()->create();

        $this->actingAs($user)->post('/orders', [
            'water_id' => $water->id,
            'quantity' => 5,
            'delivery_address' => 'Aşgabat ş.',
            'phone' => '+993 65 112233',
        ])->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_teacher_requirements_wherehas_and_auth_user_and_foreign_keys(): void
    {
        $water = $this->makeWater();
        $empty = Category::create(['name_tm' => 'Boş', 'name_ru' => 'Пустая', 'name_en' => 'Empty']);

        // whereHas()
        $withWaters = Category::whereHas('waters')->get();
        $this->assertTrue($withWaters->contains('id', $water->category_id));
        $this->assertFalse($withWaters->contains('id', $empty->id));

        $user = User::factory()->create();
        $this->actingAs($user);

        // auth()->user() + relationship + foreignId
        $order = auth()->user()->orders()->create([
            'water_id' => $water->id,
            'quantity' => 2,
            'total_price' => 5.00,
            'delivery_address' => 'Aşgabat ş.',
            'phone' => '+993 65 112233',
        ]);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'user_id' => $user->id, 'water_id' => $water->id]);
        $this->assertTrue(Order::whereHas('water')->get()->contains('id', $order->id));
        $this->assertTrue(Order::whereHas('user', fn ($q) => $q->where('id', $user->id))->exists());
    }
}
