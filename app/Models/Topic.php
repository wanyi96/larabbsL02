<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body',  'category_id',   'excerpt', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {

        //本地作用域，在方法前加上scope;定义了作用域后，可以在查询模型时调用作用域方法，调用时不需要加前缀
        //不同的排序，使用不同的数据读取逻辑
        switch($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }

    }

    public function scopeRecentReplied($query)
    {
        //大概话题有新回复时，将编写逻辑更新话题模型的reply_count属性，会更新updated_at的时间
        //根据更新时间排序
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        //根据创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = [])
    {
        //重定向带有slug的标题
        return route('topics.show',array_merge([$this->id, $this->slug], $params));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
