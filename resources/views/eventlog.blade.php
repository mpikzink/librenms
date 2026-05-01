@extends('layouts.librenmsv1')

@section('title', __('Eventlog'))

@section('content')
<div class="container-fluid">
    <div class="panel panel-default panel-condensed">
        <div class="panel-heading">
            <strong>{{ __('Eventlog') }}</strong>
        </div>
        <div class="table-responsive">
            <table id="eventlog" class="table table-hover table-condensed table-striped">
                <thead>
                    <tr>
                        <th data-column-id="label"></th>
                        <th data-column-id="device_id">{{ __('Hostname') }}</th>
                        <th data-column-id="datetime" data-order="desc">{{ __('Timestamp') }}</th>
                        <th data-column-id="type">{{ __('Type') }}</th>
                        <th data-column-id="message">{{ __('Eventlog Entries') }}</th>
                        <th data-column-id="username">{{ __('Username') }}</th>
                    </tr>
                </thead>
                @foreach($events as $event)
                    <tr>
                        <td>{!! \LibreNMS\Util\Html::severityToLabel($event->severity, '', '', 'alert-status') !!}</td>
                        <td>{{ $event->device?->hostname ?? '' }}</th>
                        <td>{{ $event->datetime }}</th>
                        <td>{{ $event->type }}<br><small>{{ $event->reference ? $event->related->sensor_descr : '' }}</small></th>
                        <td>{{ $event->message }}</th>
                        <td>{{ $event->username ?: __('System') }}</th>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
