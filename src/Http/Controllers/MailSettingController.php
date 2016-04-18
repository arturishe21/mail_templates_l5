<?php namespace Vis\MailTemplates;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class MailSettingController extends Controller
{
    public function fetchIndex()
    {
        $title = "Настройки почты";

        if (Request::ajax()) {
            $view = "part.settings_center";
        } else {
            $view = "all_settings";
        }

        $driversMail = array(
            "smtp",
            "mail",
            "sendmail",
            "mailgun",
            "mandrill",
            "log",
        );

        return View::make('mail-templates::settings.' . $view, compact("title", 'driversMail'));
    }

    public function doSave()
    {
        $file = $this->createFile();

        File::put(app_path().'/config/mail.php', $file);

        return Redirect::back()->with("text_success", __cms('Настройки почты обновлены'));
    }

    private function createFile()
    {
        $data = Input::all();
        $file = "<?php

return array( \n\n";
        foreach($data as $key => $value){

            if ($value == "false" || $value == "true") {
                $file .= "'$key' => $value, \n\n";
            } elseif(!is_array($value)) {
                $file .= "'$key'=> '$value',  \n\n";
            } else {
                $arrayFrom = "";
                foreach ($value as $arr2K => $arr2Val) {
                    $arrayFrom .= " '$arr2K' => '$arr2Val', ";
                }
                $file .= "'$key' => array($arrayFrom), \n\n";
            }

        }

        $file .= ");";

        return $file;
    }
}