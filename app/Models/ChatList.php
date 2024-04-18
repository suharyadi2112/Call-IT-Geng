<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ChatList extends Model 
{
    use HasFactory;

    protected $table = 'a_chat_list'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'user_id',
        'room_id',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function chatHistory()
    {
        return $this->hasMany(ChatHistory::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
