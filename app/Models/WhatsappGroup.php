<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappGroup extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'whatsapp_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'whstapp_subscriber_id',
        'group_identification',
        'subject',
        'subject_owner',
        'subject_time',
        'creation',
        'size',
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function whstapp_subscriber()
    {
        return $this->belongsTo(WhstappSubscriber::class, 'whstapp_subscriber_id');
    }
}
