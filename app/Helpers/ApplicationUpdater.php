<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class ApplicationUpdater
{
    public static function update($client, $data)
    {
        $client->update($data);

        return $client;
    }
}
