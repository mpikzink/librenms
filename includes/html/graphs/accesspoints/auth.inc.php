<?php

use App\Facades\DeviceCache;
use App\Models\AccessPoint;

if (is_numeric($vars['id'])) {
    $ap = AccessPoint::find($vars['id']);

    if (is_numeric($ap->device_id) && ($auth || device_permitted($ap->device_id))) {
        $title = generate_device_link(DeviceCache::get($ap->device_id)->toArray());
        $title .= ' :: AP :: ' . htmlentities($ap->name);
        $auth = true;
    }
}
