<script>
    $(".breadcrumb").html("<li><a href='/admin'>{{__cms('Главная')}}</a></li> <li>{{__cms($title)}}</li>");
    $("title").text("{{__cms($title)}} - {{ __cms(Config::get('builder::admin.caption')) }}");
</script>

<!-- MAIN CONTENT -->
<div id="content_email">
    <div class="row" style="margin-left: 0; margin-right: 0">

        {{--button add page end--}}
        <div class="jarviswidget jarviswidget-color-blue " id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa  fa-file-text"></i> </span>
                <h2> {{__cms($title)}} </h2>
            </header>
            <div class="table_center no-padding">


                <table class="table  table-hover table-bordered " id="sort_t">
                    <thead>
                    <tr>
                        <th style="width: 40px">#</th>
                        <th style="width: 20%">{{__cms('Кому')}}</th>
                        <th style="width: 25%">{{__cms('Тема письма')}}</th>
                        <th>{{__cms('Тело письма')}}</th>
                        <th>
                            {{__cms("Дата отправки")}}
                        </th>
                        <th style="width: 50px"></th>
                    </tr>
                    </thead>
                    <tbody >
                    @forelse($allMails as $mail )
                        <tr class="tr_{{$mail->id}} " id_page="{{$mail->id}}">
                            <td>{{$mail->id}}</td>
                            <td style="text-align: left;">
                                <a href="mailto:{{$mail->email_to}}">{{$mail->email_to}}</a>
                            </td>
                            <td>{{$mail->subject}}</td>
                            <td><p rel="tooltip" title="<a>Создать</a> копию">{{str_limit(strip_tags($mail->body), 70)}}</p></td>
                            <td>{{$mail->created_at}}</td>
                            <td>
                                <div class="btn-group hidden-phone pull-right">
                                    <a class="btn dropdown-toggle btn-xs btn-default"  data-toggle="dropdown"><i class="fa fa-cog"></i> <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu pull-right" id_rec ="{{$mail->id}}">
                                        <li>
                                            <a class="edit_record" onclick="Mailer.getPreview({{$mail->id}})"><i class="fa fa-eye"></i> {{__cms('Просмотреть')}}</a>
                                        </li>
                                        <li>
                                            <a onclick="Mailer.doDelete({{$mail->id}});"><i class="fa red fa-times"></i> {{__cms("Удалить")}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"  class="text-align-center">
                                {{__cms('Пусто')}}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="dt-toolbar-footer">
                    <div class="col-sm-4 col-xs-12 hidden-xs">
                        <div id="dt_basic_info" class="dataTables_info" role="status" aria-live="polite">
                            {{__cms('Показано')}}
                            <span class="txt-color-darken listing_from">{{$allMails->firstItem()}}</span>
                            -
                            <span class="txt-color-darken listing_to">{{$allMails->lastItem()}}</span>
                            {{__cms("из")}}
                            <span class="text-primary listing_total">{{$allMails->total()}}</span>
                            {{__cms("записей")}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div id="dt_basic_paginate" class="dataTables_paginate paging_simple_numbers">
                            {{$allMails->links()}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- END MAIN CONTENT -->

@include("mail-templates::mailer.part.description_mail")

<script src="{{asset('packages/vis/mail-templates/js/mailer.js')}}"></script>
