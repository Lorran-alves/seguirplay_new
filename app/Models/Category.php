<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function plansActive()
    {
        return $this->hasMany(Plan::class)->where('isActive', '1');
    }


    public function title(): Attribute
    {
        return new Attribute(
            set: fn ($value) => [
                'title' => $value,
                'description' => $value,
                'slug' => Str::slug($value),
                
            ],
        );
    }
    
    public function imageIcon(): Attribute
    {
        return new Attribute(
            get: fn() => $this->convertImageIcon($this->id),
        );
    }
    
    private function convertImageIcon($id)
    {
        if($id == 1 or $id == 17){
            return asset('web_assets/img/icons/facebook.png');
        }elseif($id == 2){
            return asset('web_assets/img/value-icon01.png');
        }elseif($id == 3){
            return asset('web_assets/img/icons/kwai.png');
        }elseif($id == 4){
            return asset('web_assets/img/icons/tiktok.png');
        }elseif($id == 5){
            return asset('web_assets/img/icons/youtube.png');
        }elseif($id == 6){
            return asset('web_assets/img/icons/loco.png');
        }elseif($id == 7){
            return asset('web_assets/img/icons/1twitch.png');
        }elseif($id == 8){
            return asset('web_assets/img/icons/1spotify.png');
        }elseif($id == 9){
            return asset('web_assets/img/icons/Rumble.png');
        }elseif($id == 10){
            return asset('web_assets/img/icons/x1.png');
        }elseif($id == 11){
            return asset('web_assets/img/icons/Kick.png');
        }elseif($id == 12){
            return asset('web_assets/img/icons/Threads.png');
        }elseif($id == 13){
            return asset('web_assets/img/icons/Telegram.png');
        }elseif($id == 14){
            return asset('web_assets/img/icons/Linkedin.png');
        }elseif($id == 15){
            return asset('web_assets/img/icons/whatsapp.png');
        }elseif($id == 16){
            return asset('web_assets/img/icons/shopee.png');
        }

        return asset('web_assets/img/icons/padrao.png');
    }
}
