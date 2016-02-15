<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class SignaturePasteValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend(
            'signature',
            function ($attribute, $value, $param, $validator) {

                //todo: just using C5 stuff for now, need expansion later
                $types = [
                    'Cosmic Anomaly' => [
                        'Combat Site' => [
                            'Core Garrison',
                            'Core Stronghold',
                            'Oruze Osobnyk',
                            'Quarantine Area',
                        ],
                        'Ore Site' => [
                            'Rarified Core Deposit',
                            'Exceptional Core Deposit',
                            'Unusual Core Deposit',
                            'Infrequent Core Deposit',
                            'Uncommon Core Deposit',
                            'Isolated Core Deposit',
                            'Average Frontier Deposit',
                            'Unexceptional Frontier Deposit',
                            'Common Perimeter Deposit',
                            'Ordinary Perimeter Deposit',
                        ],
                    ],
                    'Cosmic Signature' => [
                        'Relic Site' => [
                            'Forgotten Core Data Field',
                            'Forgotten Core Information Pen',
                        ],
                        'Data Site' => [
                            'Unsecured Frontier Enclave Relay',
                            'Unsecured Frontier Server Bank',
                        ],
                        'Gas Site' => [
                            'Vital Core Reservoir',
                            'Instrumental Core Reservoir',
                            'Vast Frontier Reservoir',
                            'Bountiful Frontier Reservoir',
                            'Ordinary Perimeter Reservoir',
                            'Sizeable Perimeter Reservoir',
                            'Minor Perimeter Reservoir',
                            'Token Perimeter Reservoir',
                            'Barren Perimeter Reservoir',
                        ],
                    ],
                ];

                $sig_components = explode("\t", $value);

                // fail if we dont have excat 5 components
                if (count($sig_components) != 6) {
                    return false;
                }

                // validate id
                //use == instead of === b/c we need to fail if no match was found and if an error occured
                if (preg_match('/^[A-Z]{3}-\d{3}$/', $sig_components[0]) == false) {
                    return false;
                }

                //validate type
                $type_keys = array_keys($types);
                if (!in_array($sig_components[1], $type_keys)) {
                    return false;
                }

                // validate group
                $group_keys = array_keys($types[$sig_components[1]]);
                if (!in_array($sig_components[2], $group_keys)) {
                    return false;
                }

                //validate name
                $name_keys = $types[$sig_components[1]][$sig_components[2]];
                if (!in_array($sig_components[3], $name_keys)) {
                    return false;
                }

                return true;
            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
