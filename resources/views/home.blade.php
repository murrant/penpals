@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('Assigned PenPals') (<span id="assigned_count">{{ $assigned->count() }}</span>)</div>

                    <div class="card-body">

                        @forelse($assigned as $address)
                            @if ($loop->first)
                                <div class="row">
                                    <div class="col-8"><h4>@lang('PenPal')</h4></div>
                                    <div class="col-4"><h4>@lang('Mail Sent?')</h4></div>
                                </div>
                            @endif
                            <div class="row" style="margin-top:20px;">
                                <div class="col-8">
                                    <strong>{{ $address->residents->first()->name }}</strong><br/>
                                    {{ $address->address }}<br/>
                                    {{ $address->city }}, {{ $address->state_name }} {{ $address->zip }}-{{ $address->zip4 }}
                                </div>
                                <div class="col-4">
                                    <input type="checkbox" class="form-control form-check-inline form-inline">
                                </div>
                            </div>
                        @empty
                            <button role="button" class="btn btn-primary">@lang('Request More')</button>
                        @endforelse

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">@lang('Completed PenPals') (<span id="completed_count">{{ $completed->count() }}</span>)</div>

                    <div class="card-body">
                        @foreach($completed as $address)
                            @if ($loop->first)
                                <div class="row">
                                    <div class="col-8"><h4>@lang('PenPal')</h4></div>
                                    <div class="col-4"><h4>@lang('Mail Sent?')</h4></div>
                                </div>
                            @endif
                            <div class="row" style="margin-top:20px;">
                                <div class="col-8">
                                    <strong>{{ $address->residents->first()->name }}</strong><br/>
                                    {{ $address->address }}<br/>
                                    {{ $address->city }}, {{ $address->state_name }} {{ $address->zip }}-{{ $address->zip4 }}
                                </div>
                                <div class="col-4">
                                    <input type="checkbox" class="form-control form-check-inline form-inline" checked>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
