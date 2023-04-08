@extends('dashboard.master')
@section('title', __('lang.edit_role'))
@section('roles_active', 'active bg-light')
@includeIf("$directory.pushStyles")

@section('content')
    <!-- page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h2 class="h5 page-title">{{ __('lang.edit_role') }}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

        <form action="{{ route('admin.roles.update', ['role' => $role]) }}" method="post" id="edit_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            <div id="loading" class="mt-2">
                @include('dashboard.modals.spinner')
            </div>
            
            <div id="edit_form_messages"></div>
        
            {{-- MODIFICATIONS FROM HERE --}}
            <div class="row">
            
                <div class="form-group col-md-10">
                    <label class="form-label">{{ __('lang.name') }}</label>
                    <input type="text" class="border form-control" name="name" placeholder="{{ __('lang.please_enter') }} {{ __('lang.name') }}..." value="{{ $role->name }}">
                </div>
                <div class="form-group col-md-2 mt-4">
                    <label class="form-check-label text-primary mt-2">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                        @lang('lang.selectAll')
                    </label>
                </div>

                <div class="form-group col-12">
                    <div class="row">
                        @if (count($groups) > 0)
                            @foreach ($groups as $group)
                                <div class="col-md-6">
                                    <label class="form-label">{{ __("lang.$group->value") }}</label>
                                    @foreach ($group->permissions as $permission)
                                        <div class="form-check form-check-primary mt-1">
                                            <input class="form-check-input" type="checkbox" name="permissionArray[{{ $permission->name }}]" id="formCheckcolor{{$permission->id}}" @checked($role->hasPermissionTo($permission->name))>
                                            <label class="form-check-label" for="formCheckcolor{{$permission->id}}">{{ __("lang.$permission->name") }}</label>
                                            {{-- {{ permission_description($permission) }} --}}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- CASE PERMISSIONS TABLE --}}
                @if (isset($caseCategories))
                    <div class="form-group col-12 mt-4">
                        <label class="form-label">{{ __('lang.case_permissions') }}</label>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered border-primary mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="20%">{{ __('lang.case') }}</th>
                                        <th class="text-center">{{ __('lang.list_case') }}</th>
                                        <th class="text-center">{{ __('lang.archive_case') }}</th>
                                        <th class="text-center">{{ __('lang.new_case') }}</th>
                                        <th class="text-center">{{ __('lang.edit_case') }}</th>
                                        <th class="text-center">{{ __('lang.delete_case') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($caseCategories as $category)
                                        <tr>
                                            <th class="bg-light">{{ $category->name }}</th>

                                            @if (count($category->permissions) > 0)
                                                @foreach ($category->permissions as $permission)
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" name="permissionArray[{{ $permission->name }}]" id="formCheckcolor{{$permission->id}}" @checked($role->hasPermissionTo($permission->name))>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
        
            </div>
            {{-- MODIFICATIONS TO HERE --}}
        
            <hr class="text-muted">

            <div class="form-group mt-3">
                <button type="button" class="btn btn-primary" id="submit_edit_form">{{ __('lang.submit') }}</button>
            </div>
        </form>

        </div>
    </div>

@endsection

@includeIf("$directory.scripts")
@includeIf("$directory.pushScripts")