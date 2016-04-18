<?php namespace Vis\MailTemplates;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class MailerController extends Controller
{
    public function fetchIndex()
    {
        $title = "Письма";
        $allMails = Mailer::orderBy('id', 'DESC')->paginate(20);

        if (Request::ajax()) {
            $view = "part.table_center";
        } else {
            $view = "mail_all";
        }

        return View::make('mail-templates::mailer.' . $view, compact("allMails", "title"));
    }

    public function fetchDescritionMail()
    {
        $mail = Mailer::find(Input::get("id"));

        return View::make('mail-templates::mailer.part.description_center', compact("mail"));
    }

    public function doDelete()
    {
        $id_page = Input::get("id");
        if ($id_page) {
            Mailer::find($id_page)->delete();
        }

        return Response::json(array('status' => 'ok'));
    }
}