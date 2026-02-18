<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhstappSubscriber extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'whstapp_subscribers';

    protected $dates = [
        'qr_updated_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'session',
        'qr',
        'qr_updated_at',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function whstappSubscriberWhatsappGroups()
    {
        return $this->hasMany(WhatsappGroup::class, 'whstapp_subscriber_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getQrUpdatedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setQrUpdatedAtAttribute($value)
    {
        $this->attributes['qr_updated_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
