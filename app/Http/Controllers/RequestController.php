<?php

namespace App\Http\Controllers;

use App\Jobs\AcceptanceJob;
use App\Mail\AcceptanceMail;
use App\Models\Request as ModelsRequest;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = (new ModelsRequest)->newQuery();

        if (request()->has('search')) {
            $requests->where('name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $requests->orderBy($attribute, $sort_order);
        } else {
            $requests->latest();
        }

        $requests = $requests
            ->with('visitors')
            ->where('status', '!=', 'finished')
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->query());

        return Inertia::render('Admin/Request/Index', [
            'requests' => $requests,
            'filters' => request()->all('search'),
            'can' => [
                'create' => Auth::user()->can('request-create'),
                'edit' => Auth::user()->can('request-edit'),
                'acceptance' => Auth::user()->can('request-acceptance'),
                'delete' => Auth::user()->can('request-delete'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = ModelsRequest::create([
            'visit_purpose' => 'Meeting',
            'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => 'ini deskripsinya',
        ]);
        $visitorData = Visitor::create([
            'ktp' => '32712931203123',
            'name' => 'ibang',
            'file_ktp' => 'ktp\32712931203123.jpg',
            'company' => 'PT Ibang',
            'occupation' => 'CEO',
            'phone' => '081923819123',
            'email' => 'ibang@mail.com',
            'pic' => true
        ]);

        $requestData->visitors()->attach($visitorData->id);

        return redirect()->route('request.index')->with('message', __('Request created successfully.'));
    }

    public function acceptance(Request $request)
    {
        $requestData = ModelsRequest::find($request->id);
        $filename = '';
        $action = $request->action . 'ed';

        if ($action == 'accepted') {
            $qrCode = QrCode::format('png')->size(256)->generate($requestData->uuid);
            $filename = '/img/qr-code/img-' . time() . '.png';
            Storage::disk('public')->put($filename, $qrCode);
            $requestData->update([
                'qrcode' => $filename
            ]);
        }

        $requestData->update([
            'status' => $action
        ]);

        $pic = $requestData->visitors()->where('pic', true)->first();

        AcceptanceJob::dispatch($pic->email, $action, $filename);

        return redirect()->route('request.index')->with('message', __('Request ' . $action . 'successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $requestData = ModelsRequest::with(['visitors' => function ($query) {
            $query->orderBy('pic', 'desc');
        }])->findOrFail($id);

        return Inertia::render('Admin/Request/Show', [
            'data' => $requestData
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $string)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $string)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $string)
    {
        //
    }
}
