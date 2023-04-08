<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermissionGroup;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    const DIRECTORY = 'back.roles';

    function __construct()
    {
        // $this->middleware('check_permission:list_roles')->only(['index', 'getData']);
        // $this->middleware('check_permission:add_roles')->only(['create', 'store']);
        // $this->middleware('check_permission:show_roles')->only(['show']);
        // $this->middleware('check_permission:edit_roles')->only(['edit', 'update']);
        // $this->middleware('check_permission:delete_roles')->only(['destroy']);
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

        $data = Role::when($word != null, function ($q) use ($word) {
            $q->where('name', 'like', '%' . $word . '%');
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
        $groups = Permission::where('guard_name', 'admin')->get();
        return view(self::DIRECTORY . ".create", get_defined_vars())->with('directory', self::DIRECTORY);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'admin']);
        if (isset($data['permissionArray'])) {
            foreach ($data['permissionArray'] as $permission => $value) {
                $role->givePermissionTo($permission);
            }
        }
        return response()->json(['success' => __('messages.sent')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $groups = Permission::where('guard_name', 'admin')->get();
        return view(self::DIRECTORY . ".show", \get_defined_vars())->with('directory', self::DIRECTORY);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $groups = Permission::where('guard_name', 'admin')->get();
        return view(self::DIRECTORY . ".edit", \get_defined_vars())->with('directory', self::DIRECTORY);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $data = $request->validated();
        $role->update(['name' => $data['name']]);
        $role->syncPermissions();
        if (isset($data['permissionArray'])) {
            foreach ($data['permissionArray'] as $permission => $value) {
                $role->givePermissionTo($permission);
            }
        }
        return response()->json(['success' => __('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->syncPermissions();
        $role->delete();
        return response()->json(['success' => __('messages.deleted')]);
    }
}
