<?php
namespace App\Models;
use illuminate\database\eloquent\model;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination;


class Payementmethods extends model{


    protected $table = 'payementmethods';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    


}