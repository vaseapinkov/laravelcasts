<?php

use App\Jobs\HandelPaddlePurchaseJob;
use App\Mail\NewPurchaseMail;
use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use Spatie\WebhookClient\Models\WebhookCall;

beforeEach(function () {
    $this->dummyWebhookCall = WebhookCall::create([
        'name' => 'default',
        'url' => 'some-url',
        'payload' => [
            'email' => 'test@test.at',
            'name' => 'Test User',
            'p_product_id' => 'pro_01hc36mbn2j94xetkhpk1n3xyx',
        ],
    ]);
});

it('stores paddle purchase', function () {
    Mail::fake();

    $this->assertDatabaseEmpty(User::class);
    $this->assertDatabaseEmpty(PurchasedCourse::class);

    $course = Course::factory()->create(['paddle_product_id' => 'pro_01hc36mbn2j94xetkhpk1n3xyx']);

    (new HandelPaddlePurchaseJob($this->dummyWebhookCall))->handle();

    $this->assertDatabaseHas(User::class, [
        'email' => 'test@test.at',
        'name' => 'Test User',
    ]);

    $user = User::where('email', 'test@test.at')->first();
    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('stores paddle purchase for a given user', function () {
    Mail::fake();

    $user = User::factory()->create(['email' => 'test@test.at']);
    $course = Course::factory()->create(['paddle_product_id' => 'pro_01hc36mbn2j94xetkhpk1n3xyx']);

    (new HandelPaddlePurchaseJob($this->dummyWebhookCall))->handle();

    $this->assertDatabaseCount(User::class, 1);
    $this->assertDatabaseHas(User::class, [
        'email' => $user->email,
        'name' => $user->name,
    ]);
    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

});

it('sends out purchase email', function () {
    Mail::fake();
    Course::factory()->create(['paddle_product_id' => 'pro_01hc36mbn2j94xetkhpk1n3xyx']);

    (new HandelPaddlePurchaseJob($this->dummyWebhookCall))->handle();
    Mail::assertSent(NewPurchaseMail::class);
});
