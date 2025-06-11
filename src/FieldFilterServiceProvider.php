<?php
namespace FieldFilter;

use Illuminate\Support\ServiceProvider;
class FieldFilterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/fields.php', 'fields');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/fields.php' => config_path('fields.php'),
        ], 'field-config');
    }
}