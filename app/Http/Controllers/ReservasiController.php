<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {

        $input = $request->all();
        $this->validate($request, [
            'meja_id' => 'required|integer',
            'harga_id' => 'required|integer',
            'user_id' => 'required|integer',
            'tanggal_booking' => 'required|date',
            'status' => 'required|in:selesai,batal,reservasi'
        ]);
        $reservasi = Reservasi::create($input);
        return response()->json($reservasi, 200);
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

        $reservasi = Reservasi::with('meja', 'harga')->OrderBy("id", "DESC")->paginate(10)->toArray();
        $response = [
            "total_count" => $reservasi["total"],
            "limit" => $reservasi["per_page"],
            "pagination" => [
                "next_page" => $reservasi["next_page_url"],
                "current_page" => $reservasi["current_page"]
            ],
            "data" => $reservasi["data"],
        ];
        return response()->json($reservasi, 200);
    }

    public function show($id)
    {
        $reservasi = Reservasi::where('user_id', Auth::user()->id)->with('meja', 'harga')->find($id);
        if (!$reservasi) {
            abort(404);
        }
        return response()->json($reservasi, 200);
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

        $reservasi = Reservasi::find($id);
        $reservasi->delete();
        $message = ['message' => 'delete sucessfull', 'id' => $id];
        return response()->json($message, 200);
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $reservasi = Reservasi::find($id);
        if (!$reservasi) {
            abort(404);
        }
        $this->validate($request, [
            'meja_id' => 'required|integer',
            'harga_id' => 'required|integer',
            'user_id' => 'required|integer',
            'tanggal_booking' => 'required|date',
            'status' => 'required|in:selesai,batal,reservasi'
        ]);
        $reservasi->fill($input);
        $reservasi->save();
        return response()->json($reservasi, 200);
    }
}