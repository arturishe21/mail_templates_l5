<?php
namespace Vis\MailTemplates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class EmailsTemplate extends Model
{
    protected $table = 'emails_template';

    /**
     * rules validation
     */
    public static $rules  = array(
        'title' => 'required',
        'slug' => 'required|max:256|unique:emails_template,slug,',
        'subject' => 'required|max:256',
    );

    protected $fillable = array('title', 'slug', 'body', 'subject');

    public $timestamps = false;

    /**
     * validation data
     *
     * @param array $data
     * @integer $id
     *
     * @return false|json
     */
    public static function isValid($data, $id)
    {
        EmailsTemplate::$rules['slug'] .= $id;

        $validator = Validator::make($data, EmailsTemplate::$rules);
        if ($validator->fails()) {
            return Response::json(
                array(
                    'status' => 'error',
                    "errors_messages" => $validator->messages()
                )
            );
        } else {
            return false;
        }
    }

    /**
     * update or create record
     *
     * @param array $data
     *
     * @return json Response
     */
    public static function doSave($data)
    {
        self::updateOrCreate(["id" => $data['id']], $data);

        return Response::json(
            array(
                "status" => "ok",
                "ok_messages" => __cms('Сохранено'),
            )
        );
    }

}