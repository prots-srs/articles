<?php
/*
TO READ

https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller

TO DO
// return view('components.ppr', ['object' => _]);
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Resident;
use App\Models\User;
use App\Repositories\ResidentRepository;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    public function __construct(
        protected ResidentRepository $repo,
    ) {
        // $this->middleware(['auth']); in route
        $this->authorizeResource(Resident::class, Resident::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // echo "<br><pre>";
        // print_r($request->ip());
        // print_r($_SERVER);
        // echo "</pre><br>";
        return view('resident.index', ['list' => $this->repo->getList()]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = $this->repo->getUserById($id);
        if ($user) {
            return view('resident.edit', ['item' => $user]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, User $user)
    {
        $user = $this->repo->getUserById($id);
        if (!$user) {
            abort(404);
        }

        $validated = $request->validate([
            'verified' => 'nullable',
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'max:100',
                Rule::unique('users', 'email')->ignore($id),
            ]
        ]);

        $this->repo->updateUser($id, $validated);

        $user = $this->repo->getUserById($id);
        if ($user) {
            return redirect(route('resident.edit', ['resident' => $user->id]));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect(route('resident.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect(route('resident.index'));
    }

    /**
     * Display the specified resource.
     */
    function show(string $id)
    {
        return redirect(route('resident.index'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect(route('resident.index'));
    }
}