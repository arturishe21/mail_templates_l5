<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
    <h4 class="modal-title" id="modal_form_label">{{__cms('Письмо')}} №{{$mail->id}} </h4>
</div>
<div class="modal-body">
    <section>
        <p>
            <strong>{{__cms('Тема письма')}}</strong>: {{{$mail->subject}}}
        </p>
    </section>

    <section>
        <p>
            <strong>{{__cms('Кому')}}</strong>: {{{$mail->email_to}}}
        </p>
    </section>
    <section>
        <p>
            <strong>{{__cms('Дата отправки')}}</strong>: {{{$mail->created_at}}}
        </p>
    </section>
    <section>
        <p><strong>{{__cms('Тело письма')}}</strong>:</p>
        <div>
            {{{$mail->body}}}
        </div>
    </section>
</div>
