<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ChatRoom extends Model
{
    use HasFactory;

    protected $table = 'a_chat_rooms'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'description', 
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];

    public function chatLists()
    {
        return $this->hasMany(ChatList::class);
    }

    public function chatHistory()
    {
        return $this->hasMany(ChatHistory::class, ChatList::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
