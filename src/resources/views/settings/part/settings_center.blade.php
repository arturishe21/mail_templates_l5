<style>
    .smart-form fieldset{
        background: none;
    }
    .jarviswidget{
        margin-bottom: 0;
    }
    .smart-form fieldset.smtp_fieldset, .smart-form fieldset.send_mail_fieldset{
         display: none;
    }
    @if(Config::get("mail.driver") == "smtp")
     .smart-form fieldset.smtp_fieldset{
        display: block;
     }
    @endif

     @if(Config::get("mail.driver") == "sendmail")
     .smart-form fieldset.send_mail_fieldset{
        display: block;
     }
    @endif

</style>
 <script>
   $(".breadcrumb").html("<li><a href='/admin'>{{__cms('Главная')}}</a></li> <li>{{__cms($title)}}</li>");
   $("title").text("{{__cms($title)}} - {{{ __cms(Config::get('builder::admin.caption')) }}}");
 </script>

<div id="content_email">
  <div class="row" style="margin-left: 0; margin-right: 0">
       <div class="jarviswidget jarviswidget-color-blue " id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false">
          <header>
              <span class="widget-icon"> <i class="fa  fa-file-text"></i> </span>
              <h2> {{__cms($title)}} </h2>
          </header>
       </div>

       <form class="smart-form" method="post" action="{{route('email_settings_save')}}">

        <p style="text-align: center; color: green; padding-top: 10px">{{Session::get('text_success');}}</p>

        <div class="row">

              <section class="col col-6">
                 <fieldset>
                    <section>
                          <label class="label">{{__cms('Драйвер')}}</label>
                          <label class="select">
                              <select class="input-sm" name="driver">
                                  @foreach($driversMail as $driver)
                                      <option value="{{$driver}}" {{$driver ==  Config::get("mail.driver") ? "selected" : ""}}>{{$driver}}</option>
                                  @endforeach
                              </select>
                              <i></i>
                          </label>
                      </section>
                  </fieldset>

                  <fieldset>
                      <div class="row">
                           <section class="col col-6">
                               <label class="label">{{__cms('Обратный адрес в письме')}}</label>
                               <label class="input">
                                 <input class="input-sm" name="from[address]" value="{{Config::get("mail.from.address")}}">
                               </label>
                           </section>
                           <section class="col col-6">
                               <label class="label">{{__cms('Имя отправителя')}}</label>
                               <label class="input">
                                    <input class="input-sm" name="from[name]" value="{{Config::get("mail.from.name")}}">
                                </label>
                           </section>
                        </div>
                     </fieldset>

                   <fieldset>
                      <section>
                        <label class="toggle">
                           <input type="hidden" name="pretend" value="false">
                            <input type="checkbox" value="true" {{Config::get("mail.pretend") ? "checked ='checked'" : ""}}  name="pretend">
                            <i data-swchon-text="{{__cms("ДА")}}" data-swchoff-text="{{__cms("НЕТ")}}"></i>
                            {{__cms('Тестовый режим')}}
                        </label>
                        <div class="note">{{__cms('Если включен тестовый режим, то письма не будут уходить, а будут складываться в лог файл')}}</div>
                        </section>
                   </fieldset>

                   <fieldset>
                        <section>
                            <input type="hidden" name="encryption" value="tls">
                            <button class="btn btn-primary" type="submit"> {{__cms('Сохранить')}} </button>
                        </section>
                   </fieldset>


              </section>
              <section class="col col-6">
                <fieldset class="smtp_fieldset">
                   <section>
                       <label class="label">SMTP Host Address</label>
                       <label class="input">
                           <input class="input-sm" value="{{Config::get("mail.host")}}" name="host">
                       </label>
                   </section>
                 </fieldset>
                 <fieldset class="smtp_fieldset">
                   <section>
                       <label class="label">SMTP Host Port</label>
                       <label class="input">
                           <input class="input-sm" name="port" value="{{Config::get("mail.port")}}">
                       </label>
                   </section>
                </fieldset>
                <fieldset class="smtp_fieldset">
                   <section>
                       <label class="label">SMTP Server Username</label>
                       <label class="input">
                           <input class="input-sm" name="username"  value="{{Config::get("mail.username")}}">
                       </label>
                   </section>
                </fieldset>
                <fieldset class="smtp_fieldset">
                   <section>
                       <label class="label">SMTP Server Password</label>
                       <label class="input">
                           <input class="input-sm" name="password" value="{{Config::get("mail.password")}}">
                       </label>
                   </section>
                </fieldset>

                <fieldset class="send_mail_fieldset">
                   <section>
                       <label class="label">Sendmail System Path</label>
                       <label class="input">
                           <input class="input-sm" name="sendmail" value="{{Config::get("mail.sendmail")}}">
                       </label>
                   </section>
                </fieldset>

              </section>


        </div>
       </form>
  </div>
</div>

<script>
    $("[name=driver]").change(function(){
        if ($(this).val() == "smtp") {
            $(".smtp_fieldset").show();
            $(".send_mail_fieldset").hide();
        } else if($(this).val() == "sendmail") {
           $(".send_mail_fieldset").show();
           $(".smtp_fieldset").hide();
        } else {
           $(".send_mail_fieldset").hide();
           $(".smtp_fieldset").hide();
        }
    });
</script>