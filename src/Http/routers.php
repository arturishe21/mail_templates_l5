<?php

Route::group (['middleware' => ['web']], function () {

    Route::group (
        ['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {

            Route::any(
                'emails/letter_template', array(
                    'as' => 'letter_all',
                    'uses' => 'Vis\MailTemplates\MailController@fetchIndex'
                )
            );

            Route::any(
                'emails/mailer', array(
                    'as' => 'mailer',
                    'uses' => 'Vis\MailTemplates\MailerController@fetchIndex'
                )
            );

            Route::any(
                'emails/settings', array(
                    'as' => 'email_settings',
                    'uses' => 'Vis\MailTemplates\MailSettingController@fetchIndex'
                )
            );

            Route::post(
                'emails/settings_save', array(
                    'as' => 'email_settings_save',
                    'uses' => 'Vis\MailTemplates\MailSettingController@doSave'
                )
            );


            if (Request::ajax()) {
                Route::post(
                    'emails/create_pop', array(
                        'as' => 'created_email',
                        'uses' => 'Vis\MailTemplates\MailController@fetchCreate'
                    )
                );
                Route::post(
                    'emails/add_record', array(
                        'as' => 'add_email',
                        'uses' => 'Vis\MailTemplates\MailController@doSave'
                    )
                );
                Route::post(
                    'emails/delete', array(
                        'as' => 'delete_email',
                        'uses' => 'Vis\MailTemplates\MailController@doDelete'
                    )
                );
                Route::post(
                    'emails/edit_record', array(
                        'as' => 'edit_email',
                        'uses' => 'Vis\MailTemplates\MailController@fetchEdit'
                    )
                );

                Route::post(
                    'mailer/show_mail', array(
                        'as' => 'show_mail',
                        'uses' => 'Vis\MailTemplates\MailerController@fetchDescritionMail'
                    )
                );

                Route::post(
                    'mailer/delete', array(
                        'as' => 'delete_email',
                        'uses' => 'Vis\MailTemplates\MailerController@doDelete'
                    )
                );

            }
        });
});


