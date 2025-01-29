<?php

use App\Facades\DeviceCache;
use LibreNMS\Util\Rewrite;

if (is_numeric($vars['id']) && ($auth || port_permitted($vars['id']))) {
    $port = cleanPort(get_port_by_id($vars['id']));
    $device = DeviceCache::get($port['device_id']);
    $title = generate_device_link($device->toArray());
    $title .= ' :: Port  ' . generate_port_link($port);

    $graph_title = $device->shortDisplayName() . '::' . strtolower(Rewrite::shortenIfName($port['ifDescr']));

    if (($port['ifAlias'] != '') && ($port['ifAlias'] != $port['ifDescr'])) {
        $title .= ', ' . \LibreNMS\Util\Clean::html($port['ifAlias'], []);
        $graph_title .= '::' . \LibreNMS\Util\Clean::html($port['ifAlias'], []);
    }

    $auth = true;

    $rrd_filename = get_port_rrdfile_path($device->hostname, $port['port_id']);
}
