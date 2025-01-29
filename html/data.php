<?php

/**
 * LibreNMS
 *
 *   This file is part of LibreNMS.
 *
 * @copyright  (C) 2006 - 2012 Adam Armstrong
 */

use App\Facades\DeviceCache;

$init_modules = ['web', 'auth'];
require realpath(__DIR__ . '/..') . '/includes/init.php';

if (is_numeric($_GET['id']) && (\LibreNMS\Config::get('allow_unauth_graphs') || port_permitted($_GET['id']))) {
    $port = cleanPort(get_port_by_id($_GET['id']));
    $device = DeviceCache::get($port['device_id']);
    $title = generate_device_link($device->toArray());
    $title .= ' :: Port  ' . generate_port_link($port);
    $auth = true;

    $in = SnmpQuery::get('IF-MIB::ifHCInOctets.' . $port['ifIndex']);
    if (empty($in)) {
        $in = SnmpQuery::get('IF-MIB::ifInOctets.' . $port['ifIndex']);
    }

    $out = SnmpQuery::get('IF-MIB::ifHCOutOctets.' . $port['ifIndex']);
    if (empty($out)) {
        $out = SnmpQuery::get('IF-MIB::ifOutOctets.' . $port['ifIndex']);
    }

    $time = microtime(true);

    printf("%lf|%s|%s\n", $time, $in, $out);
}
