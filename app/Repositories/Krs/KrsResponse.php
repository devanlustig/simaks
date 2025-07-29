<?php

namespace App\Repositories\Krs;

use Carbon\Carbon;
use App\Models\Krs;
use App\Repositories\Krs\KrsDesign;


class KrsResponse  implements KrsDesign {
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    public function __construct(Krs $model)
    {
        $this->model = $model;
    }

   

    /**
     * Query for create data Matakuliah method.
     */
    public function create($param)
    {
        
        return $this->model->create([
            'userid'     => $param->userid,
            'id_matakuliah'      => $param->id_matakuliah,
            'total_sks'     => $param->total_sks,
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
            'userid'     => $param->userid,
            'id_matakuliah'      => $param->id_matakuliah,
            'total_sks'     => $param->total_sks,
        ]);
            return $result;
    }

}
