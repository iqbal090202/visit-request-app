<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScannerController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Scanner/Index');
    }

    public function checkQrCode(Request $request)
    {
        $requestData = ModelsRequest::where('uuid', $request->id)->whereDate('start_date', Carbon::now())->first();

        if (!$requestData) {
            return response()->json(['message' => 'error bos...'], 500);
        }

        if ($requestData->status != 'accepted') {
            return response()->json(['message' => 'udah masuk bos'], 500);
        }

        $requestData->update([
            'status' => 'finished'
        ]);

        return response()->json(['message' => 'Silahkan Masuk']);
    }
}
