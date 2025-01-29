<?php

use App\Facades\DeviceCache;
use App\Models\BgpPeer;

if (is_numeric($vars['id'])) {
    $data = BgpPeer::find($vars['id']);

    if (is_numeric($data->device_id) && ($auth || device_permitted($data->device_id))) {
        $device = DeviceCache::get($data->device_id);

        $title = generate_device_link($device->toArray());
        $title .= ' :: BGP :: ' . htmlentities($data->bgpPeerIdentifier);
        $auth = true;
    }
}
