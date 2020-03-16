<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bigdata extends Model
{
    protected  $table = 'rs_scrapy_menu_last_data_province';

    public  $timestamps = false;

    protected  $fillable = ['titem','tvalue','t_data','code','t_str_data','areacode'];


}
