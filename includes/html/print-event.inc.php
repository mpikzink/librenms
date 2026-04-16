<?php

use App\Facades\DeviceCache;
use LibreNMS\Util\Rewrite;
use LibreNMS\Util\Url;

/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       https://www.librenms.org
 * @copyright  2017 LibreNMS
 * @author     LibreNMS Contributors
*/

$device = DeviceCache::get((int) $entry['device_id']);

$severity_colour = eventlog_severity($entry['severity']);
$icon = '<span class="alert-status ' . $severity_colour . '"></span>';

echo '<tr>';
echo '<td>' . $icon . '</td>';
echo '<td style="vertical-align: middle;">' . $entry['datetime'] . '</td>';

if ($device) {
    echo '<td style="vertical-align: middle;">' . Url::deviceLink($device, $device->shortDisplayName()) . '</td>';
}

if ($entry['type'] == 'interface') {
    $this_if = cleanPort(get_port_by_id($entry['reference']));
    $entry['link'] = '<b>' . generate_port_link($this_if, Rewrite::shortenIfName(strtolower((string) $this_if['label']))) . '</b>';
} else {
    $entry['link'] = 'System';
}

echo '<td style="vertical-align: middle;">' . $entry['link'] . '</td>';

echo '<td style="vertical-align: middle;">' . htmlspecialchars((string) $entry['message']) . '</td>';
echo '</tr>';
