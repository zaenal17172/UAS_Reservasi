<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BayarController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'total' => 'required|integer',
            'reservasi_id' => 'required|integer'
        ]);
        $bayar = Bayar::create($input);
        return response()->json($bayar, 200);
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

        $bayar = Bayar::with('reservasi')->OrderBy("id", "DESC")->paginate(10)->toArray();
        $response = [
            "total_count" => $bayar["total"],
            "limit" => $bayar["per_page"],
            "pagination" => [
                "next_page" => $bayar["next_page_url"],
                "current_page" => $bayar["current_page"]
            ],
            "data" => $bayar["data"],
        ];
        return response()->json($bayar, 200);
    }

    public function show($id)
    {
        $bayar = Bayar::with('reservasi')->find($id);
        if (!$bayar) {
            abort(404);
        }
        return response()->json($bayar, 200);
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
        $bayar = Bayar::find($id);
        $bayar->delete();
        $message = ['message' => 'delete sucessfull', 'id' => $id];
        return response()->json($message, 200);
    }
}