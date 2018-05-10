<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id;	// 限制只有作者自己才能对自己创建的话题进行编辑
        // return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return true;
    }
}
