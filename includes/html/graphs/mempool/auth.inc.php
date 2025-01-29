<?php

use App\Models\Mempool;

if (is_numeric($vars['id'])) {
    $mempool = Mempool::with('device')->find($vars['id']);

    if (is_numeric($mempool->device_id) && ($auth || device_permitted($mempool->device_id))) {
        $rrd_filename = Rrd::name($mempool->device->hostname, ['mempool', $mempool->mempool_type, $mempool->mempool_class, $mempool->mempool_index]);
        $title = generate_device_link($mempool->device->toArray());
        $title .= ' :: Memory Pool :: ' . htmlentities($mempool->mempool_descr);
        $auth = true;
    }
}
