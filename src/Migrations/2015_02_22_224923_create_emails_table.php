<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('emails_template')) {
            Schema::create('emails_template', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->string('slug', 255)->unique();
                $table->string('title',255);
                $table->string('subject',255);
                $table->text('body');
            });
        }

        if (!Schema::hasTable('mailer')) {
            Schema::create('mailer', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->string('email_to', 255);
                $table->string('subject', 255);
                $table->string('body', 255);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails_template');
        Schema::dropIfExists('mailer');
    }

}
