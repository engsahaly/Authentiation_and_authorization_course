{{-- MODIFICATIONS FROM HERE --}}
<div class="row">
    <div class="form-group col-md-6">
        <label class="form-label">{{ __('lang.name') }}</label>
        <p class="border form-control">{{ $admin->name ?? '--' }}</p>
    </div>

    <div class="form-group col-md-6">
        <label class="form-label">{{ __('lang.email') }}</label>
        <p class="border form-control">{{ $admin->email ?? '--' }}</p>
    </div>

    <div class="form-group col-12">
        <label class="form-label">{{ __('lang.role') }}</label>
        <p class="border form-control mb-1">{{ $admin->getRoleNames()[0] ?? '--' }}</p>
    </div>
</div>
{{-- MODIFICATIONS TO HERE --}}

<hr class="text-muted">

<div class="form-group float-end">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
</div>
