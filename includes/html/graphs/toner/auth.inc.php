<?php

use App\Models\PrinterSupply;

if (is_numeric($vars['id'])) {
    $toner = PrinterSupply::with('device')->find($vars['id']);

    if (is_numeric($toner->device_id) && ($auth || device_permitted($toner->device_id))) {
        $rrd_filename = Rrd::name($toner->device->hostname, ['toner', $toner->supply_type, $toner->supply_index]);

        $title = generate_device_link($toner->device->toArray());
        $title .= ' :: Toner :: ' . htmlentities($toner->supply_descr);
        $auth = true;
    }
}
