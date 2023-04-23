<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = User::filters();
        $users = QueryBuilder::for(User::class)
            ->select('id', 'first_name', 'last_name', 'email', 'role')
            ->allowedFilters(getAllowedFilters($filters))
            ->paginate(10);

        $filters = collect(['filters' => $filters]);
        $data = $filters->merge($users);

        return response(['users' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Str::random(8);
        $user = User::create($data);

        // Send email with initial password.

        return response()->json(['user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with([
            'bookCheckouts:id,active,book_id,user_id',
            'bookCheckouts.book:id,title'
        ])->findOrFail($id);

        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $user->update($data);

        return response()->json(['user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
