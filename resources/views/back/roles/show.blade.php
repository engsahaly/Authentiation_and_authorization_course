@extends('back.master')
@section('title', __('lang.show_role'))
@section('roles_active', 'active bg-light')
@includeIf("$directory.pushStyles")

@section('content')
    <!-- page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h2 class="h5 page-title">{{ __('lang.show_role') }}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- MODIFICATIONS FROM HERE --}}
            <div class="row">

                <div class="form-group col-12">
                    <label class="form-label">{{ __('lang.name') }}</label>
                    <p class="border form-control">{{ $role->name ?? '--' }}</p>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        @if (count($groups) > 0)
                            @foreach ($groups as $permission)
                                <div class="col-md-6">
                                    <div class="form-check form-check-primary mt-1">
                                        <input class="form-check-input" type="checkbox" disabled
                                            @checked($role->hasPermissionTo($permission->name))>
                                        <div class="d-inline-block">
                                            <label class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
            {{-- MODIFICATIONS TO HERE --}}

        </div>
    </div>

@endsection

@includeIf("$directory.scripts")
@includeIf("$directory.pushScripts")
