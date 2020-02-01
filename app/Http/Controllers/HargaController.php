<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HargaController extends Controller
{
    public function store(Request $request)
    {
        // Authorization Admin
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'you are unauthorized'
            ], 403);
        }

        $input = $request->all();

        $this->validate($request, [
            'biaya' => 'required|integer',
            'kursi' => 'required|in:2,4,6,8,10'
        ]);
        $harga = Harga::create($input);
        return response()->json($harga, 200);
    }

    public function index()
    {
        // Authorization Admin
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'you are unauthorized'
            ], 403);
        }

        $harga = Harga::OrderBy("id", "DESC")->paginate(10)->toArray();
        $response = [
            "total_count" => $harga["total"],
            "limit" => $harga["per_page"],
            "pagination" => [
                "next_page" => $harga["next_page_url"],
                "current_page" => $harga["current_page"]
            ],
            "data" => $harga["data"],
        ];
        return response()->json($harga, 200);
    }

    public function destroy($id)
    {
        // Authorization Admin
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'you are unauthorized'
            ], 403);
        }

        $harga = Harga::find($id);
        $harga->delete();
        $message = ['message' => 'delete sucessfull', 'id' => $id];
        return response()->json($message, 200);
    }

    public function update(Request $request, $id)
    {
        // Authorization Admin
        if (Gate::denies('admin')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'you are unauthorized'
            ], 403);
        }

        $input = $request->all();
        $harga = Harga::find($id);
        if (!$harga) {
            abort(404);
        }
        $this->validate($request, [
            'biaya' => 'required|integer',
            'kursi' => 'required|in:2,4,6,8,10'
        ]);
        $harga->fill($input);
        $harga->save();
        return response()->json($harga, 200);
    }
}