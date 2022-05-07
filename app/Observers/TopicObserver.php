<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //过滤发帖的数据
        $topic->body = clean($topic->body, 'user_topic_body');

        //保存topic数据时，生成摘要字段再保存
        $topic->excerpt = make_excerpt($topic->body);
    }
}

