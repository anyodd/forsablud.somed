<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbcontr extends Model
{
    use HasFactory;
    protected $table = 'tb_contr';
    protected $fillable = ['id_contr','Ko_Period','Ko_unit1', 'No_contr', 'dt_contr', 'Ur_contr', 'nm_BU', 'adr_BU','nm_pimbu','nm_ppk','Tag','tb_ulog','created_at','updated_at'];
    protected $primaryKey = 'id_contr';
}
