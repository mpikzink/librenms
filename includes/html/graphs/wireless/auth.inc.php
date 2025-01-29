<?php

use App\Facades\DeviceCache;
use App\Models\WirelessSensor;

if (is_numeric($vars['id'])) {
    $sensor = WirelessSensor::find($vars['id']);

    if (is_numeric($sensor->device_id) && ($auth || device_permitted($sensor->device_id))) {
        $device = DeviceCache::get($sensor['device_id']);

        $rrd_filename = Rrd::name($device->hostname, ['wireless-sensor', $sensor->sensor_class, $sensor->sensor_type, $sensor->sensor_index]);

        $title = generate_device_link($device->toArray());
        $title .= ' :: Wireless Sensor :: ' . htmlentities($sensor->sensor_descr);
        $auth = true;
    }
}
