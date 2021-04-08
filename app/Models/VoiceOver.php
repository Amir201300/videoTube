<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceOver extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models(){
        return $this->hasMany(VoiceOverModel::class,'voice_id');
    }
}
