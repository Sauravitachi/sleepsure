<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomerInformation extends Authenticatable
{
    use Notifiable;

    protected $table = 'customer_information';
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'first_name',
        'last_name',
        'birth_day',
        'customer_short_address',
        'customer_address_1',
        'customer_address_2',
        'city',
        'state',
        'country',
        'zip',
        'customer_mobile',
        'customer_email',
        'vat_no',
        'cr_no',
        'previous_balance',
        'image',
        'password',
        'token',
        'company',
        'status',
        'gid',
        'guid',
        'fid',
        'fuid',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];
}
