<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition()
    {
        //sentence()方法会随机生成小段落文本
        $sentence  = $this->faker->sentence();

        return [
            // $this->faker->name,
            'title' => $sentence,
            'body' => $this->faker->text(), //text()会随机生成大段落文本
            'excerpt' => $sentence,
            'user_id' =>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'category_id' => $this->faker->randomElement([1,2,3,4]),
        ];
    }
}
