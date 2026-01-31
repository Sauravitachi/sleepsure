<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftSetting extends Model
{
    protected $table = 'soft_setting'; 
    protected $primaryKey = 'setting_id'; 
    public $timestamps = false;
    
    protected $fillable = [
        'logo', 'invoice_logo', 'favicon', 'footer_text', 'country_id',
        'language', 'time_zone', 'rtr', 'captcha', 'site_key', 'secret_key', 'sms_service'
    ];
}