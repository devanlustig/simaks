<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Matakuliah
 *
 * @property int $id
 * @property string $namaMatakuliah
 * @property string $sks
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 */


class Matakuliah extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_matakuliah','sks'
    ];
}
