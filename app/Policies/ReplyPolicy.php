<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {

        //拥有回复删除权限的只能是回复的作者或者是话题的作者
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
