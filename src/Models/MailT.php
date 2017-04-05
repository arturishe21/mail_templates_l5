<?php namespace Vis\MailTemplates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class MailT extends Model {

    public $to = "";
    public $name = "";
    public $no_write_bd = false;
    public $attach = "";
    private $subject = "";
    private $body = "";

    /**
     * MailT constructor.
     *
     * @param string $slug
     * @param array $params
     *
     * @return void
     */
    public function __construct($slug, $params)
    {
        if ($slug && $params) {
            $result = EmailsTemplate::where("slug", $slug)->first();

            foreach ($params as $k => $el) {
                $search[] = "{" . $k . "}";
                $replace[] = $el;
            }
            $search[] = "{domen}";
            $replace[] = $_SERVER['HTTP_HOST'];

            if (isset($result->id)) {
                $this->subject = $result->subject;
                $this->body = $result->body;

                $this->body = str_replace(
                    '/images/', 'http://' . $_SERVER['HTTP_HOST'] . "/images/",
                    $this->body
                );
                $this->body = str_replace($search, $replace, $this->body);
                $this->subject = str_replace($search, $replace, $this->subject);
            } else {
                throw new \RuntimeException("Ошибка. Не в базе не найден шаблон письма " . $slug);
            }
        }

    }

    /**
     * send mail
     *
     * @return bool
     */
    public function send()
    {
        if ($this->to && $this->body && $this->subject) {
            $data = array("body" => $this->body);

            //save in logs
            if ($this->no_write_bd === false) {
                $this->doAddMailer();
            }

            Mail::send('mail-templates::email_body', $data, function($message)
            {
                if (strpos($this->to, ",")) {
                    $toArray = explode(",", $this->to);

                    foreach ($toArray as $email) {
                        $email = trim($email);
                        $message->to($email)->subject($this->subject);
                    }
                } else {
                    $message->to($this->to)->subject($this->subject);
                }

                //if isset attach file
                if ($this->attach) {
                    if (is_array($this->attach)) {
                        foreach ($this->attach as $attach) {
                            $message->attach($attach->getRealPath(), array(
                                    'as' => $attach->getClientOriginalName(),
                                    'mime' => $attach->getMimeType())
                            );
                        }
                    } else {
                        $message->attach($this->attach->getRealPath(), array(
                                'as' => $this->attach->getClientOriginalName(),
                                'mime' => $this->attach->getMimeType())
                        );
                    }
                }
            });

            return true;

        } else {
            return false;
        }
    }

    /**
     * add in log mail table
     *
     * @return void
     */
    private function doAddMailer()
    {
        Mailer::create(
            array(
                "email_to" => $this->to,
                "subject" => $this->subject,
                "body" => $this->body,
            )
        );
    }
}
