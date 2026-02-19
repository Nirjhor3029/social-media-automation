<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;

    public $table = 'customer_groups';

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'description',
        'status',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
