<form action="{{ route('back.admins.update', ['admin' => $admin]) }}" method="post" id="edit_form"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div id="edit_form_messages"></div>

    {{-- MODIFICATIONS FROM HERE --}}
    <div class="row">
        <div class="form-group col-md-6">
            <label class="form-label">{{ __('lang.name') }}</label>
            <input type="text" class="border form-control" name="name"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.name') }}..." value="{{ $admin->name }}">
        </div>

        <div class="form-group col-md-6">
            <label class="form-label">{{ __('lang.email') }}</label>
            <input type="email" class="border form-control" name="email"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.email') }}..." value="{{ $admin->email }}">
        </div>

        {{-- <div class="form-group col-md-12">
            <label class="form-label">{{ __('lang.role') }}</label>
            <select class="border form-control" name="role">
                <option value="">{{ __('lang.select_role') }}</option>
                @foreach ($roles as $item)
                    <option value="{{ $item->name }}" @selected($admin->hasRole($item->name))>{{ $item->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group col-6">
            <label class="form-label">{{ __('lang.password') }}</label>
            <input type="password" class="border form-control" name="password"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.password') }}...">
        </div>

        <div class="form-group col-6">
            <label class="form-label">{{ __('lang.password_confirmation') }}</label>
            <input type="password" class="border form-control" name="password_confirmation"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.password_confirmation') }}...">
        </div>
    </div>
    {{-- MODIFICATIONS TO HERE --}}

    <hr class="text-muted">

    <div class="form-group float-end">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
        <button type="button" class="btn btn-primary" id="submit_edit_form">{{ __('lang.submit') }}</button>
    </div>
</form>
