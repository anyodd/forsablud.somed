<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsaran extends Model
{
    use HasFactory;
    protected $table = 'tb_saran';
    protected $fillable = ['ur_menu', 'kondisi', 'saran', 'tgl_saran', 'pesan_error', 'user', 'telp', 'tanggapan', 'status'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $dates = ['tgl_saran', 'tgl_tanggapan'];
}
