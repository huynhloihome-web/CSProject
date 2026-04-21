<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';

    protected $primaryKey = 'ma_don_hang';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tong_tien',
        'status',
    ];
}