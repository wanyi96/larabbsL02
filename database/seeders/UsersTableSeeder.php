<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成数据集合
        User::factory()->count(10)->create();

        //单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'wanyi';
        $user->email = '408629610@qq.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();

        //初始化用户角色，将1号用户指定为站长
        $user->assignRole('Founder');
        //将2号用户指定为管理员
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
