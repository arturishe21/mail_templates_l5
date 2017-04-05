<?php namespace Vis\MailTemplates;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class MailController extends Controller
{
    /**
     * list templates mails return
     *
     * @return Illuminate\Support\Facades\View
     */
    public function fetchIndex()
    {
        $allpage = EmailsTemplate::orderBy('id', 'DESC')->paginate(20);

        if (Request::ajax()) {
            $view = "part.table_center";
        } else {
            $view = "email_all";
        }

        return View::make('mail-templates::' . $view)
            ->with('title', Config::get('mail-templates.config.title_page'))
            ->with("data", $allpage);
    }

    /**
     * get popup create mail template
     *
     * @return Illuminate\Support\Facades\View
     */
    public function fetchCreate()
    {
        return View::make('mail-templates::part.form_emails');
    }

    /**
     * get popup edit mail tempalte
     *
     * @return mixed
     */
    public function fetchEdit()
    {
        $id = Input::get("id");
        if (is_numeric($id)) {
            $page = EmailsTemplate::find($id);

            return View::make('mail-templates::part.form_emails')->with('info', $page);
        }
    }

    /**
     * do save mail template
     *
     * @return false|json
     */
    public function doSave()
    {
        parse_str(Input::get('data'), $data);

        $validation = EmailsTemplate::isValid($data, $data['id']);
        if ($validation) {
            return $validation;
        }

        return EmailsTemplate::doSave($data);
    }

    /**
     * delete mail template
     *
     * @return mixed
     */
    public function doDelete()
    {
        $id_page = Input::get("id");
        if ($id_page) {
            EmailsTemplate::find($id_page)->delete();
        }

        return Response::json(array('status' => 'ok'));
    }
}
