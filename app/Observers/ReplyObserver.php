<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
        $reply->topic->updateReplyCount(); //回复创建完后，计算本话题下的回复总数，再赋值

        //回复创建后，通知作者
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function updating(Reply $reply)
    {
        //
    }

    //话题，回复被删除后要更新话题数
    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
