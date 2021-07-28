<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{
    Organization,
    Receiver,
    ReceiverData,
    User
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $model = User::where(['email' => 'gratus@example.com'])->first();

        if (!$model) {
            User::factory()->create([
                'email' => 'gratus@example.com',
            ]);
        }

        $number = rand(30, 50);
        Receiver::factory($number)
            ->has(ReceiverData::factory()->count(1))
            ->hasCreditCard(1, function(array $attributes, Receiver $receiver) {
                $attributes['cardable_id'] = $receiver->id;
                $attributes['cardable_type'] = Receiver::class;
                return $attributes;
            })
            ->hasBankAccount(1, function(array $attributes, Receiver $receiver) {
                $attributes['accountable_id'] = $receiver->id;
                $attributes['accountable_type'] = Receiver::class;
                return $attributes;
            })
            ->create();
        User::factory($number)->create();
        Organization::factory($number)->create();
    }
}
