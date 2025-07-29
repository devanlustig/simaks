<?php

namespace App\Repositories\Krs;


interface KrsDesign {

    public function create($param);
    public function edit($id);
    public function update($param, $id);

}
