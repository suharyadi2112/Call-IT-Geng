<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ChatHistory extends Model
{
    use HasFactory;
    
    protected $table = 'a_chat_history'; 

    protected $primaryKey = 'id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'chat_list_id',
        'sender_id',
        'message_content',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chatList()
    {
        return $this->belongsTo(ChatList::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
