<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    // 一对一关系，有了这样的关联设定，后面开发中我们可以很方便地通过 $topic->category、$topic->user 来获取到话题对应的分类和作者。
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

	// 一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
