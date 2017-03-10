<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCommented;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'last_name','first_name','email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function createPost(array $data)
    {
        $post=new Post($data);
        $this->posts()->save($post);
        $this->subscribeTo($post);
        return $post;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class,'subscriptions');
    }

    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id',$post->id)->count()>0;
    }

    public function subscribeTo(Post $post)
    {
        $this->subscriptions()->attach($post);
    }
    
    public function unSubscribeFrom(Post $post)
    {
        $this->subscriptions()->detach($post);
    }

    public function comment(Post $post,$message)
    {
        $comment=new Comment(
            [
                'comment'=>$message,
                'post_id'=>$post->id
            ]
        );

        $this->comments()->save($comment);
        Notification::send(
            $post->subscribers()->where('users.id','!=',$this->id)->get(),new PostCommented($comment));
        return $comment;
    }

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function getNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }
}
