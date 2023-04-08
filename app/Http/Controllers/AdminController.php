<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Branch;
use App\Enums\AdminStatuses;
use Illuminate\Http\Request;
use App\Services\UploadService;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    const DIRECTORY = 'back.admins';

    function __construct()
    {
        // $this->middleware('check_permission:list_admins')->only(['index', 'getData']);
        // $this->middleware('check_permission:add_admins')->only(['create', 'store']);
        // $this->middleware('check_permission:show_admins')->only(['show']);
        // $this->middleware('check_permission:edit_admins')->only(['edit', 'update']);
        // $this->middleware('check_permission:delete_admins')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->getData($request->all());
        return view(self::DIRECTORY . ".index", \get_defined_vars())->with('directory', self::DIRECTORY);
    }

    /**
     * Get data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($data)
    {
        $order   = $data['order'] ?? 'created_at';
        $sort    = $data['sort'] ?? 'desc';
        $perpage = $data['perpage'] ?? \config('app.paginate');
        $start   = $data['start'] ?? null;
        $end     = $data['end'] ?? null;
        $word    = $data['word'] ?? null;

        $data = Admin::when($word != null, function ($q) use ($word) {
            $q->where('name', 'like', '%' . $word . '%')
                ->orWhere('email', 'like', '%' . $word . '%');
        })
            ->when($start != null, function ($q) use ($start) {
                $q->whereDate('created_at', '>=', $start);
            })
            ->when($end != null, function ($q) use ($end) {
                $q->whereDate('created_at', '<=', $end);
            })
            ->orderby($order, $sort)->paginate($perpage);

        return \get_defined_vars();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view(self::DIRECTORY . ".create", get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::create($data);
        if (isset($data['role'])) $admin->assignRole($data['role']);
        return response()->json(['success' => __('messages.sent')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        if (!$admin->super_admin) return view(self::DIRECTORY . ".show", \get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        if (!$admin->super_admin) return view(self::DIRECTORY . ".edit", \get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();
        if ($data['password'] == null) unset($data['password']);
        $admin->update($data);
        $admin->syncRoles([$data['role']]);
        return response()->json(['success' => __('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->syncRoles();
        $admin->delete();
        return response()->json(['success' => __('messages.deleted')]);
    }
}
