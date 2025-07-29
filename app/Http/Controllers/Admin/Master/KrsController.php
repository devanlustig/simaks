<?php

namespace App\Http\Controllers\Admin\Master;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\krsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\krs\editRequest;
use App\Http\Requests\krs\krsRequest;
use App\Repositories\Krs\KrsResponse;
use App\Models\Matakuliah;
use App\Models\Krs;


class KrsController extends Controller
{

    protected $KrsResponse ;
    public function __construct(KrsResponse  $KrsResponse)
    {
        $this->KrsResponse  = $KrsResponse;
        $this->middleware('permission:Krs Show',       ['only' => ['index']]);
        $this->middleware('permission:Krs Create',     ['only' => ['create','Store']]);
        $this->middleware('permission:Krs Edit',       ['only' => ['edit','update']]);
    }

    public function index(Request $request)
    {
        $matakuliahs = Matakuliah::all();

        $krs = Krs::where('userid', auth()->id())->first(); // atau 'userid' sesuai nama kolommu
        $selected_ids = [];
        $total_sks = 0;

        if ($krs) {
            $selected_ids = explode(',', $krs->id_matakuliah); // atau 'id_matakuliah'
            $total_sks = $krs->total_sks;
        }

        return view('master.krs.index', compact('matakuliahs', 'selected_ids', 'total_sks'));
    }

   
    public function create()
    {
        return view('master.krs.create');
    }

    
    public function Stores(krsRequest $request)
    {
        try {
            $this->KrsResponse->create($request);
                $notification = ['message'      => 'Successfully created new krs.',
                                  'alert-type'  => 'primary',
                                  'gravity'     => 'bottom',
                                  'position'    => 'right'];
                    return redirect()->route('krs.index')->with($notification);
        } catch (\Exception $e) {
            
            $notification = ['message'     => 'Failed to created data new krs.',
                             'alert-type'  => 'danger',
                             'gravity'     => 'bottom',
                             'position'    => 'right'];
                return redirect()->route('krs.index')->with($notification);
            
        }
    }

    public function store(Request $request)
    {
        $ids = $request->matakuliah_ids;

        if (!$ids || !is_array($ids)) {
            return redirect()->back()->with('message', 'Matakuliah harus dipilih.');
        }

        $matakuliahs = Matakuliah::whereIn('id', $ids)->get();
        $total_sks = $matakuliahs->sum('sks');

        // Validasi total SKS tidak boleh lebih dari 22
        if ($total_sks > 22) {
            return redirect()->back()->with('message', 'Total SKS tidak boleh melebihi 22.');
        }

        // Simpan atau update KRS
        Krs::updateOrCreate(
            ['userid' => auth()->id()],
            [
                'id_matakuliah' => implode(',', $ids),
                'total_sks' => $total_sks
            ]
        );

        return redirect()->back()->with('message', 'Data KRS berhasil disimpan.');
    }




    
    public function edit($id)
    {
        $result = $this->KrsResponse->edit($id);
            return view('master.krs.edit',compact('result'));
    }

    
    public function update(editRequest $request, $id)
    {
        try {
            $this->KrsResponse->update($request, $id);
                $notification = ['message'      => 'Successfully updated krs.',
                                'alert-type'  => 'success',
                                'gravity'     => 'bottom',
                                'position'    => 'right'];
                return redirect()->route('krs.index')->with($notification);
        } catch (\Exception $e) {
                $notification = ['message'     => 'Failed to updated data krs.',
                                'alert-type'  => 'danger',
                                'gravity'     => 'bottom',
                                'position'    => 'right'];
                return redirect()->route('krs.index')->with($notification);
        }
    }
  
}
