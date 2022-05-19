<?php

namespace App\Jobs;

use App\Handlers\SlugTranslateHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        //
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);
        //模型监控器调用队列，异步获取翻译，为了防止死循环，此处使用DB操作
        DB::table('topics')->where('id', $this->topic->id)->update(['slug'=> $slug]);
    }
}
