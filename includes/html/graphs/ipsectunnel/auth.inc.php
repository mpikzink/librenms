<?php

use App\Models\IpsecTunnel;

if (is_numeric($vars['id'])) {
    $tunnel = IpsecTunnel::with('device')->find($vars['id']);

    if (is_numeric($tunnel->device_id) && ($auth || device_permitted($tunnel->device_id))) {
        $rrd_filename = Rrd::name($tunnel->device->hostname, ['ipsectunnel', $tunnel->peer_addr]);

        $title = generate_device_link($tunnel->device->toArray());
        $title .= ' :: IPSEC Tunnel :: ' . htmlentities($tunnel->peer_addr);
        $auth = true;
    }
}
