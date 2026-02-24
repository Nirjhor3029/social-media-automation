<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappQuery extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope('owned_queries', function ($builder) {
            if (auth()->check() && !auth()->user()->is_admin) {
                $builder->whereHas('whstapp_subscriber', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            }
        });
    }

    public $table = 'whatsapp_queries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'whstapp_subscriber_id',
        'question',
        'answer',
        'hit_count',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function whstapp_subscriber()
    {
        return $this->belongsTo(WhstappSubscriber::class, 'whstapp_subscriber_id');
    }
}
