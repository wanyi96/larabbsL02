<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    //$request 指经过验证后的request数据， $topic 指的是要修改的id对应的topic实例
    public function update(TopicRequest $request, Topic $topic)
    {
        // dd($topic->user->id);
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return new TopicResource($topic);
    }
}
