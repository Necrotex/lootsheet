<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class FleetCompositionPasteValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('fleet_composition', function ($attribute, $value, $param, $validator) {
            $lines = explode("\n", $value);

            foreach ($lines as $line) {
                $data = explode("\t", $line);

                if (count($data) != 7) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
