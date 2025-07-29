<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Matakuliah
 *
 * @property int $id
 * @property string $id_matakuliah
 * @property string $total_sks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */


class Krs extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'krs_datas';
    protected $fillable = [
        'userid','total_sks','id_matakuliah'
    ];
}
