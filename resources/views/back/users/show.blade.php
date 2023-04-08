{{-- MODIFICATIONS FROM HERE --}}
<div class="row">
    <div class="form-group col-12 col-md-6">
        <label class="form-label">{{ __('lang.name') }}</label>
        <p class="border form-control">{{ $user->name ?? '--' }}</p>
    </div>

    <div class="form-group col-12 col-md-6">
        <label class="form-label">{{ __('lang.email') }}</label>
        <p class="border form-control">{{ $user->email ?? '--' }}</p>
    </div>
</div>
{{-- MODIFICATIONS TO HERE --}}


<div class="form-group float-end">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
</div>
