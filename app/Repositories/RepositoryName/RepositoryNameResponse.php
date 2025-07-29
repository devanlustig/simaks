<?php

namespace App\Repositories\RepositoryName;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RepositoryName;

class RepositoryNameResponse extends Eloquent implements RepositoryNameDesign{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected RepositoryName $model;

    public function __construct(RepositoryName $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
