<?php

use App\Models\Processor;

$proc = Processor::with('device')->find($vars['id']);

if (is_numeric($proc->device_id) && ($auth || device_permitted($proc->device_id))) {
    $rrd_filename = Rrd::name($proc->device->hostname, ['processor', $proc->processor_type, $proc->processor_index]);
    $title = generate_device_link($proc->device->toArray());
    $title .= ' :: Processor :: ' . htmlentities($proc->processor_descr);
    $auth = true;
}
