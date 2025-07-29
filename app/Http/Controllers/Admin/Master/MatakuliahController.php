<?php

namespace App\Http\Controllers\Admin\Master;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\MatakuliahExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\matakuliah\editRequest;
use App\Http\Requests\matakuliah\matakuliahRequest;
use App\Repositories\Matakuliah\MatakuliahResponse;


class MatakuliahController extends Controller
{

    protected $MatakuliahResponse ;
    public function __construct(MatakuliahResponse  $MatakuliahResponse)
    {
        $this->MatakuliahResponse  = $MatakuliahResponse;
        $this->middleware('permission:Matakuliah Show',       ['only' => ['index']]);
        $this->middleware('permission:Matakuliah Create',     ['only' => ['create','Store']]);
        $this->middleware('permission:Matakuliah Edit',       ['only' => ['edit','update']]);
        $this->middleware('permission:Matakuliah Trash',      ['only' => ['trashData','Trash']]);
        $this->middleware('permission:Matakuliah Excel',      ['only' => ['downloadExcel']]);
        $this->middleware('permission:Matakuliah Delete',     ['only' => ['delete']]);
    }

    /**
     * List Data Matakuliah
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $result = $this->MatakuliahResponse->datatable();
                return DataTables::eloquent($result)

                                ->addColumn('action', function ($action) {

                                    if (auth()->user()->can('Matakuliah Trash')) {
                                        $Trash  =   '
                                                        <button class="btn btn-danger btn-sm btn-size btn-trash"
                                                            data-id="'.$action->id.'">
                                                            Trash
                                                        </button>
                                                    ';
                                    } else {
                                        $Trash =   '';
                                    }

                                    if (auth()->user()->can('Matakuliah Edit')) {
                                        $Edit   =   '
                                                        <a href="'.url(route('matakuliah.edit',$action->id)).'" type="button" class="btn btn-success btn-sm btn-size">
                                                            Edit
                                                        </a>
                                                    ';
                                    } else {
                                        $Edit   =   '';
                                    }
                                        return $Edit." ".$Trash;
                                })

                                ->rawColumns(['action'])
                                ->escapeColumns(['action'])
                                ->smart(true)
                                ->make();
        }
            return view('master.matakuliah.index');
    }

    /**
     * Process moving data Trash
     */
    public function trashData($id)
    {
        try {
            $this->MatakuliahResponse->trashedData($id);
            $message = "Successfully to moving Trash data Matakuliah.";
            $success = true;
        } catch (\Exception $e) {
            $message = "Failed to moving data Trash";
            $success = false;
        }
            if($success == true) {
                /**
                 * Return response true
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }elseif($success == false){
                /**
                 * Return response false
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
    }

    /**
     * List Data Trash Matakuliah.
     */
    public function Trash(Request $request)
    {
        if($request->ajax()) {
            $result = $this->MatakuliahResponse->datatable()
                            ->onlyTrashed();
                return DataTables::of($result)
                        ->addIndexColumn(['address'])

                        ->addColumn('action', function ($action) {
                            if (auth()->user()->can('Matakuliah Delete')) {
                                $Delete  =  '
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    data-uuid="'.$action->id.'">
                                                    Delete
                                                </button>
                                            ';
                            } else {
                                $Delete = '';
                            }

                            if (auth()->user()->can('Matakuliah Restore')) {
                                $Restore  = '
                                                <button class="btn btn-primary btn-sm btn-restore"
                                                    data-uuid="'.$action->id.'">
                                                    Restore
                                                </button>
                                            ';
                            } else {
                                $Restore    = '';
                            }
                                return $Delete." ".$Restore;

                        })

                        ->editColumn('age', function ($age) {
                            return $age->age. " Years";
                        })

                        ->editColumn('deleted_at', function ($deleted) {
                            $date = Carbon::create($deleted->deleted_at)->format('Y-m-d H:i:s');
                            return $date;
                        })

                        ->rawColumns(['action'])
                        ->escapeColumns(['action'])
                        ->smart(true)
                        ->make();
        }
            return view('master.matakuliah.trash');
    }

    /**
     * View Create Data Matakuliah.
     */
    public function create()
    {
        return view('master.matakuliah.create');
    }

    /**
     * Process Create Data Matakuliah.
     */
    public function Store(matakuliahRequest $request)
    {
        try {
            $this->MatakuliahResponse->create($request);
                $notification = ['message'      => 'Successfully created new Matakuliah.',
                                  'alert-type'  => 'primary',
                                  'gravity'     => 'bottom',
                                  'position'    => 'right'];
                    return redirect()->route('matakuliah.index')->with($notification);
        } catch (\Exception $e) {
            
            $notification = ['message'     => 'Failed to created data new Matakuliah.',
                             'alert-type'  => 'danger',
                             'gravity'     => 'bottom',
                             'position'    => 'right'];
                return redirect()->route('matakuliah.index')->with($notification);
            
        }
    }

    /**
     * View Edit Data Matakuliah.
     */
    public function edit($id)
    {
        $result = $this->MatakuliahResponse->edit($id);
            return view('master.matakuliah.edit',compact('result'));
    }

    /**
     * Process Edit Data Matakuliah.
     */
    public function update(editRequest $request, $id)
    {
        try {
            $this->MatakuliahResponse->update($request, $id);
                $notification = ['message'      => 'Successfully updated matakuliah.',
                                'alert-type'  => 'success',
                                'gravity'     => 'bottom',
                                'position'    => 'right'];
                return redirect()->route('matakuliah.index')->with($notification);
        } catch (\Exception $e) {
                $notification = ['message'     => 'Failed to updated data matakuliah.',
                                'alert-type'  => 'danger',
                                'gravity'     => 'bottom',
                                'position'    => 'right'];
                return redirect()->route('matakuliah.index')->with($notification);
        }
    }

    /**
     * Process moving Restore data Matakuliah.
     */
    public function RestoreData($id)
    {
        try {
            $this->MatakuliahResponse->restore($id);
            $message = "Successfully to moving Restore data matakuliah.";
            $success = true;
        } catch (\Exception $e) {
            $message = "Failed to moving Restore data matakuliah.";
            $success = false;
        }
            if($success == true) {
                /**
                 * Return response true
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }elseif($success == false){
                /**
                 * Return response false
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
    }

    /**
     * Process Delete Permanent Data Matakuliah.
     */
    public function delete($id)
    {
        try {
            $this->MatakuliahResponse->deletePermanent($id);
            $message = "Successfully to Delete Permanent Data matakuliah.";
            $success = true;
        } catch (\Exception $e) {
            $message = "Failed to Delete Permanent data matakuliah Trash";
            $success = false;
        }
            if($success == true) {
                /**
                 * Return response true
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }elseif($success == false){
                /**
                 * Return response false
                 */
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
    }

    /**
     * Process Report Data Excel Matakuliah.
     */
    public function downloadExcel()
    {
        /** 
         * Maximum Time Setting 1800 seconds
         * (30 Minutes)
         * */
        ini_set('max_execution_time', 1800);
        date_default_timezone_set('Asia/Jakarta');
        $date       = date('Y-m-d-H-i-s');
            return Excel::download(new MatakuliahExport(), "Matakuliah-$date.xlsx");
    }
}
