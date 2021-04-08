<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialties(){
        return $this->belongsTo(Specialty::class,'specialties_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goal(){
        return $this->belongsTo(Goal::class,'specialties_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function audience(){
        return $this->belongsTo(Audience::class,'audience_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Sector(){
        return $this->belongsTo(Sector::class,'Sector_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voiceModelArabic(){
        return $this->belongsTo(VoiceOverModel::class,'voiceModelArabic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voiceModelEnglish(){
        return $this->belongsTo(VoiceOverModel::class,'voiceModelEnglish_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialLinks(){
        return $this->hasMany(OrderSocial::class,'order_id');
    }
}
