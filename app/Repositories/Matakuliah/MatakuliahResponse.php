<?php

namespace App\Repositories\Matakuliah;

use Carbon\Carbon;
use App\Models\Matakuliah;
use App\Repositories\Matakuliah\MatakuliahDesign;


class MatakuliahResponse  implements MatakuliahDesign {
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    public function __construct(Matakuliah $model)
    {
        $this->model = $model;
    }

    /**
     * Query for datatable without get() method.
     */
    public function datatable()
    {
        return $this->model->select('id','nama_matakuliah','sks','deleted_at');
    }

    /**
     * Query for create data Matakuliah method.
     */
    public function create($param)
    {
        
        return $this->model->create([
            'nama_matakuliah'     => $param->nama_matakuliah,
            'sks'      => $param->sks,
        ]);
    }

    public function edit($id)
    {
        $result = $this->model->where('id',$id)->first();
            return $result;
    }

    public function update($param, $id)
    {
        

        $result = $this->model->where('id',$id)->update([
            'nama_matakuliah'     => $param->nama_matakuliah,
            'sks'      => $param->sks,
        ]);
            return $result;
    }

    /**
     * Query for trashedData Method.
     */
    public function trashedData($id)
    {
        $result = $this->model->find($id);
            return $result->delete();
    }

    /**
     * Query for Restore Data.
     */
    public function restore($id)
    {
        $result = $this->model
                        ->withTrashed()
                        ->find($id);
            return $result->restore();
    }

    /**
     * Query for Delete Permanent Data.
     */
    public function deletePermanent($id)
    {
        $result = $this->model
                        ->withTrashed()
                        ->find($id);
            return $result->forceDelete();
    }
}
