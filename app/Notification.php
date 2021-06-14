<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $table = "uit_notifications";

    protected $fillable = [
        'user_id', 'type_id', 'message', 'content', 'receiver_id', 'has_seen'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(NotificationType::class, 'type_id');
    }
}
