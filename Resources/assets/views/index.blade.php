@extends('vpsmanager::layouts.vps_manager_layout')

@section('title', 'VPS Manager')

@section('css')
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
    .expiration-days {
        font-weight: bold;
    }
    .text-orange {
        color: #FFA500;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">VPS Manager</h1>
    <div class="mb-3">
        <form action="{{ route('vpsmanager.update') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-raised btn-primary">Update VPS Instances</button>
        </form>
    </div>
    <div class="table-responsive">
        <table id="vps-table" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>CID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>IP Address</th>
                    <th>Creation Date</th>
                    <th>Status</th>
                    <th>Days until expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instances as $instance)
                    <tr>
                        <td>{{ $instance->cid }}</td>
                        <td>{{ $instance->full_name }}</td>
                        <td>{{ $instance->email }}</td>
                        <td>{{ $instance->ip_address }}</td>
                        <td>{{ $instance->creation_date }}</td>
                        <td>{{ $instance->status }}</td>
                        <td class="expiration-days" data-days="{{ $instance->days_until_expiration }}">
                            {{ $instance->days_until_expiration }}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-raised btn-outline-primary restart-btn" data-id="{{ $instance->id }}">Restart</button>
                                <button type="button" class="btn btn-sm btn-raised btn-outline-danger terminate-btn" data-id="{{ $instance->id }}">Terminate</button>
                                <button type="button" class="btn btn-sm btn-raised btn-outline-warning report-btn" data-id="{{ $instance->id }}">Report Issue</button>
                                <button type="button" class="btn btn-sm btn-raised btn-outline-info notice-btn" data-id="{{ $instance->id }}">Send Notice</button>
                                <button type="button" class="btn btn-sm btn-raised btn-outline-success extend-btn" data-id="{{ $instance->id }}">Extend</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Extend Expiration -->
<div class="modal fade" id="extendModal" tabindex="-1" role="dialog" aria-labelledby="extendModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extendModalLabel">Extend Expiration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="extendForm">
                    <div class="form-group">
                        <label for="days">Number of days to extend:</label>
                        <select class="form-control" id="days" name="days">
                            <option value="7">7 days</option>
                            <option value="15">15 days</option>
                            <option value="30">30 days</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-raised btn-primary" id="confirmExtend">Extend</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ Module::asset('vpsmanager:js/vps_manager.js') }}"></script>
@endsection