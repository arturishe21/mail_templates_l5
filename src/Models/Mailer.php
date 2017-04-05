<?php namespace Vis\MailTemplates;

use Illuminate\Database\Eloquent\Model;

class Mailer extends Model
{
    protected $table = 'mailer';

    protected $fillable = array('email_to', 'subject', 'body');
}
