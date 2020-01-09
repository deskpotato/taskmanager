<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false => true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>[
                'required',
                Rule::unique('projects')->where(function($query){
                    return $query->where('user_id',request()->user()->id);
                })
        ],
            'thumbnail'=>'image|dimensions:min_width=260,min_height=100'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'项目名称必填~',
            'name.unique'=>'项目名称必须是唯一的~',
            'thumbnail.image'=>'请上传一个文件~',
            'thumbnail.dimensions'=>'图片尺寸必须是xx*yy~',
        ];
    }
}
