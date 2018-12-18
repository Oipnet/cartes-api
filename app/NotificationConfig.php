<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationConfig extends Model
{
    protected $fillable = [ 'id_notification', 'channel', 'type', 'destination', 'active'];

    public function scopeIsActive($query)
    {
        return $query->where('active', '=', true);
    }

    public function scopeFindByNotificationId($query, $id)
    {
        return $query->where('id_notification', '=', $id);
    }
}
