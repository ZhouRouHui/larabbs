<?php

namespace App\Transformers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'category'];
    /**
     * 设置了 protected $availableIncludes = ['user', 'category']，可以理解为可以嵌套的额外资源有 user 和 
     * category。那么额外的资源如何获取，如何转换，则通过 includeUser 和 includeCategory 确定，availableIncludes 
     * 中的每一个参数都对应一个具体的方法，方法命名规则为 include + user 、 include + category 驼峰命名。
     * 那么什么时候才会引入额外的资源呢，由客户端提交的 include 参数指定，多个参数通过逗号分隔。
     */

    public function transform(Topic $topic)
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'body' => $topic->body,
            'user_id' => (int) $topic->user_id,
            'category_id' => (int) $topic->category_id,
            'reply_count' => (int) $topic->reply_count,
            'view_count' => (int) $topic->view_count,
            'last_reply_user_id' => (int) $topic->last_reply_user_id,
            'excerpt' => $topic->excerpt,
            'slug' => $topic->slug,
            'created_at' => $topic->created_at->toDateTimeString(),
            'updated_at' => $topic->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Topic $topic)
    {
        return $this->item($topic->user, new UserTransformer());
    }

    public function includeCategory(Topic $topic)
    {
        return $this->item($topic->category, new CategoryTransformer());
    }
}