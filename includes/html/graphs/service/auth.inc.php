<?php

use App\Models\Service;

if (is_numeric($vars['id'])) {
    $service = Service::with('device')->find($vars['id']);

    if (is_numeric($service->device_id) && ($auth || device_permitted($service->device_id))) {
        // This doesn't quite work for all yet.
        $rrd_filename = Rrd::name($service->device->hostname, ['service', $service->service_type, $service->service_id]);

        $title = generate_device_link($service->device->toArray());
        $title .= ' :: Service :: ' . htmlentities($service->service_type) . ' - ' . htmlentities($service->service_desc);
        $auth = true;
    }
}
