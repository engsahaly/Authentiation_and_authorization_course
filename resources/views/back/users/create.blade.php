<form action="{{ route('back.users.store') }}" method="post" id="add_form" enctype="multipart/form-data">
    @csrf

    <div id="add_form_messages"></div>

    {{-- MODIFICATIONS FROM HERE --}}
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label class="form-label">{{ __('lang.name') }}</label>
            <input type="text" class="border form-control" name="name"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.name') }}...">
        </div>

        <div class="form-group col-12 col-md-6">
            <label class="form-label">{{ __('lang.email') }}</label>
            <input type="email" class="border form-control" name="email"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.email') }}...">
        </div>

        <div class="form-group col-12 col-md-6">
            <label class="form-label">{{ __('lang.password') }}</label>
            <input type="password" class="border form-control" name="password"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.password') }}...">
        </div>

        <div class="form-group col-12 col-md-6">
            <label class="form-label">{{ __('lang.password_confirmation') }}</label>
            <input type="password" class="border form-control" name="password_confirmation"
                placeholder="{{ __('lang.please_enter') }} {{ __('lang.password_confirmation') }}...">
        </div>
    </div>
    {{-- MODIFICATIONS TO HERE --}}

    <div class="form-group float-end mt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
        <button type="button" class="btn btn-primary" id="submit_add_form">
            {{ __('lang.submit') }}
        </button>
    </div>
</form>
