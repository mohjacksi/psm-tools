@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.channel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.id') }}
                        </th>
                        <td>
                            {{ $channel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.name') }}
                        </th>
                        <td>
                            {{ $channel->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.channel.fields.biological_set') }}
                        </th>
                        <td>
                            {{ $channel->biological_set->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#channel_channel_psms" role="tab" data-toggle="tab">
                {{ trans('cruds.channelPsm.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#channel_samples" role="tab" data-toggle="tab">
                {{ trans('cruds.sample.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="channel_channel_psms">
            @includeIf('admin.channels.relationships.channelChannelPsms', ['channelPsms' => $channel->channelChannelPsms])
        </div>
        <div class="tab-pane" role="tabpanel" id="channel_samples">
            @includeIf('admin.channels.relationships.channelSamples', ['samples' => $channel->channelSamples])
        </div>
    </div>
</div>

@endsection