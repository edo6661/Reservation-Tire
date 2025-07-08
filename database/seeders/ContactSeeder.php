<?php
namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use App\Enums\ContactSituation;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $customerUsers = User::where('role', UserRole::CUSTOMER)->get();
        
        if ($customerUsers->count() > 0) {
            
            Contact::factory()->unanswered()->create([
                'reception_id' => $customerUsers->first()->id,
                'title' => 'Request to change reservation date',
                'text' => 'Hi, I would like to change my reservation from January 15th to January 20th. Is this possible?',
                'sender' => $customerUsers->first()->email,
            ]);
            
            Contact::factory()->unanswered()->create([
                'reception_id' => $customerUsers->skip(1)->first()->id,
                'title' => 'Question about tire storage service',
                'text' => 'I am interested in your tire storage service. Can you provide more details about pricing and duration?',
                'sender' => $customerUsers->skip(1)->first()->email,
            ]);
            
            
            Contact::factory()->answered()->create([
                'reception_id' => $customerUsers->skip(2)->first()->id,
                'title' => 'Coupon code not working',
                'text' => 'I tried to use coupon code SAVE20 but it says invalid. Can you help?',
                'sender' => $customerUsers->skip(2)->first()->email,
                'answer_title' => 'Re: Coupon code not working',
                'answer_text' => 'Thank you for contacting us. The coupon code SAVE20 has expired. Please use our new code WINTER25 for 25% off tire installation services.',
            ]);
            
            Contact::factory()->answered()->create([
                'reception_id' => $customerUsers->skip(3)->first()->id,
                'title' => 'Confirmation of reservation cancellation',
                'text' => 'Please confirm that my reservation for January 12th has been cancelled.',
                'sender' => $customerUsers->skip(3)->first()->email,
                'answer_title' => 'Re: Confirmation of reservation cancellation',
                'answer_text' => 'Your reservation for January 12th has been successfully cancelled. You will receive a confirmation email shortly.',
            ]);
            
            
            Contact::factory()->count(5)->create([
                'reception_id' => $customerUsers->random()->id,
            ]);
        }
    }
}