<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    const DIRECTORY = 'back.users';

    function __construct()
    {
        // $this->middleware('check_permission:add_user')->only(['create', 'store']);
        // $this->middleware('check_permission:show_user')->only(['show']);
        // $this->middleware('check_permission:edit_user')->only(['edit', 'update']);
        // $this->middleware('check_permission:delete_user')->only(['destroy']);
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
        $order       = $data['order'] ?? 'created_at';
        $sort        = $data['sort'] ?? 'desc';
        $perpage     = $data['perpage'] ?? \config('app.paginate');
        $start       = $data['start'] ?? null;
        $end         = $data['end'] ?? null;
        $word        = $data['word'] ?? null;
        $status      = $data['status'] ?? null;

        $data = User::when($status != null, function ($q) use ($status) {
            $q->where('status', $status);
        })
            ->when($word != null, function ($q) use ($word) {
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
        Gate::forUser(Auth::guard('admin')->user())->authorize('add_user');
        // if (Auth::guard('admin')->user()->cannot('add_user')) {
        //     abort(403);
        // }
        return view(self::DIRECTORY . ".create", get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        User::create($data);
        return response()->json(['success' => __('messages.sent')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view(self::DIRECTORY . ".show", \get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view(self::DIRECTORY . ".edit", \get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if ($data['password'] == null) unset($data['password']);
        $user->update($data);
        return response()->json(['success' => __('messages.updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => __('messages.deleted')]);
    }
}
