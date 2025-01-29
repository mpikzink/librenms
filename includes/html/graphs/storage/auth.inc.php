<?php

if (is_numeric($vars['id'])) {
    $storage = Storage::with('device')->find($vars['id']);

    if (is_numeric($storage->device_id) && ($auth || device_permitted($storage->device_id))) {
        $rrd_filename = Rrd::name($storage->device->hostname, ['storage', $storage->type, $storage->storage_descr]);

        $title = generate_device_link($storage->device->toArray());
        $title .= ' :: Storage :: ' . htmlentities($storage->storage_descr);
        $auth = true;
    }
}
