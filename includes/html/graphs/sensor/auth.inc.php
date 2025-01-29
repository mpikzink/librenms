<?php

use App\Models\Sensor;

if (is_numeric($vars['id'])) {
    $sensor = Sensor::with('device')->find($vars['id']);

    if ($auth || device_permitted($sensor->device_id)) {
        $rrd_filename = get_sensor_rrd($sensor->device->toArray(), $sensor);

        $title = generate_device_link($sensor->device->toArray());
        $title .= ' :: Sensor :: ' . htmlentities($sensor->sensor_descr);
        $auth = true;
    }
}
