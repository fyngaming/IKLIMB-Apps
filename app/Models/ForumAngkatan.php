<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAngkatan extends Model
{
    use HasFactory;

    protected $table = 'forum_angkatans';

    protected $fillable = [
        'angkatan',
        'tahun_lulus',
        'nama_koordinator',
        'no_wa_koordinator',
        'link_wa_group',
        'keterangan',
    ];
}
