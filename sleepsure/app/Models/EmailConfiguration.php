<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
	protected $table = 'email_configuration';

	public $timestamps = false;

	protected $fillable = [
		'email_id',
		'protocol',
		'mailtype',
		'smtp_host',
		'smtp_port',
		'sender_email',
		'password',
	];
}
