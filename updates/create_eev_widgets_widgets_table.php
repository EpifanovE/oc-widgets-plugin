<?php namespace EEV\Leads\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateEevLeadsLeads extends Migration
{
    public function up()
    {
        Schema::create('eev_widgets_widgets', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 1024)->nullable();
            $table->string('type', 64);
            $table->json('data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('eev_widgets_widgets');
    }
}
