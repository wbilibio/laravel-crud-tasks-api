<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserChanged;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function list()
    {
        $listUsers = User::all();

        return response()->json([
            'status' => 'success',
            'list' => $listUsers
        ]);
    }

    public function get($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $userUpdated = User::findOrFail($id);

            $userUpdated->name = $request->input('name');
            $userUpdated->email = $request->input('email');

            $userUpdated->save();

            $user = Auth::user();
            $user->notify(new UserChanged('O usuário ' . $userUpdated->name . ' foi alterado.'));

            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }

    public function destroy($id)
    {
        try {
            $userDeleted = User::findOrFail($id);
            $name = $userDeleted->name;

            $userDeleted->delete();

            $user = Auth::user();
            $user->notify(new UserChanged('O usuário ' . $name . ' foi deletado.'));

            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 301);
        }
    }
}
