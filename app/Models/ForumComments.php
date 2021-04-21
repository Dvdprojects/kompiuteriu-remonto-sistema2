<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ForumComments
 *
 * @property int $id
 * @property int $user_id
 * @property int $forums_id
 * @property string $forum_post_comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Forum $forumPost
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments query()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereForumPostComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereForumsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumComments whereUserId($value)
 * @mixin \Eloquent
 */
class ForumComments extends Model
{
    use HasFactory;
    protected $fillable = ['forum_post_comment'];

    public function user(){
        return $this->belongsTo(User::Class, 'user_id', 'id');
    }
    public function forumPost(){
        return $this->belongsTo(Forum::Class, 'forums_id', 'id');
    }
}
