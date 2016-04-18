<?php namespace Vis\MailTemplates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class Mailer extends Model
{
    protected $table = 'mailer';

    protected $fillable = array('email_to', 'subject', 'body');
}
