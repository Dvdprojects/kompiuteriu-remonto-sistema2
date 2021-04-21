<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Forum
 *
 * @property int $id
 * @property int $user_id
 * @property string $forum_subject
 * @property string $forum_comment
 * @property int $public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Forum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum query()
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereForumComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereForumSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumComments[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @property int $group
 * @method static \Illuminate\Database\Eloquent\Builder|Forum groups($groupId)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forum public()
 */
class Forum extends Model
{
    use HasFactory;

    protected $fillable = ['forum_subject', 'forum_comment'];

    public function user(){
        return $this->belongsTo(User::Class);
    }
    public function comments(){
        return $this->hasMany(ForumComments::Class, 'forums_id', 'id');
    }
    public function scopeGroups(Builder $query, $groupId){
        return $query->where('group', '=', $groupId);
    }
    public function scopePublic(Builder $query, $id){
        return $query->where('public', '=', $id);
    }
}
