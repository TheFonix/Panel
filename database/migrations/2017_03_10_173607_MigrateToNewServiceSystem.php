<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */
use Pterodactyl\Models\Service;
use Pterodactyl\Models\ServiceOption;
use Illuminate\Database\Migrations\Migration;

class MigrateToNewServiceSystem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::transaction(function () {
            $service = Service::where('author', config('pterodactyl.service.core'))->where('folder', 'srcds')->first();
            if (! $service) {
                return;
            }

            $options = ServiceOption::where('service_id', $service->id)->get();
            $options->each(function ($item) use ($options) {
                if ($item->tag === 'srcds' && $item->name === 'Insurgency') {
                    $item->tag = 'insurgency';
                } elseif ($item->tag === 'srcds' && $item->name === 'Team Fortress 2') {
                    $item->tag = 'tf2';
                } elseif ($item->tag === 'srcds' && $item->name === 'Custom Source Engine Game') {
                    $item->tag = 'source';
                }
                $item->save();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Not doing reversals right now...
    }
}
