<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MejaController extends Controller
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

        $this->validate($request, [
            'no_meja' => 'required',
            'kursi' => 'required|in:2,4,6,8,10',
            'posisi' => 'required|in:in,out',
            'status' => 'required|in:ada,kosong'
        ]);
        $meja = new Meja();
        $meja->no_meja = $request->input('no_meja');
        $meja->kursi = $request->input('kursi');
        $meja->posisi = $request->input('posisi');
        $meja->status = $request->input('status');
        $meja->save();
        return response()->json($meja, 200);
    }

    public function index()
    {
        // Authorization Admin and User
        if (Gate::denies('admin-user')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'you are unauthorized'
            ], 403);
        }
        if (Auth::user()->role === 'Admin') {
            $meja = Meja::OrderBy("id", "DESC")->paginate(10)->toArray();
        } else {
            $meja = Meja::where('status', 'kosong')->OrderBy("id", "DESC")->paginate(10)->toArray();
        }

        $response = [
            "total_count" => $meja["total"],
            "limit" => $meja["per_page"],
            "pagination" => [
                "next_page" => $meja["next_page_url"],
                "current_page" => $meja["current_page"]
            ],
            "data" => $meja["data"],
        ];
        return response()->json($meja, 200);
    }

    public function show($id)
    {
        $meja = Meja::find($id);
        if (!$meja) {
            abort(404);
        }
        return response()->json($meja, 200);
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

        $meja = Meja::find($id);
        $meja->delete();
        $message = ['message' => 'delete sucessfull', 'id' => $id];
        return response()->json($message, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $meja = Meja::find($id);
        if (!$meja) {
            abort(404);
        }
        $this->validate($request, [
            'no_meja' => 'required',
            'kursi' => 'required|in:2,4,6,8,10',
            'posisi' => 'required|in:in,out',
            'status' => 'required|in:ada,kosong'
        ]);
        $meja->fill($input);
        $meja->save();
        return response()->json($meja, 200);
    }
}