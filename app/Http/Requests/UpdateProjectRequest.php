<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateProjectRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
                Rule::unique('projects')->ignore($this->route('project'))->where(function($query){
                    return $query->where('user_id',request()->user()->id);
                })
            ],
            'thumbnail'=>'image|dimensions:min_width=260,min_height=90|max:2048'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'项目名称必填~',
            'thumbnail.image'=>'请上传一个文件~',
            'thumbnail.dimensions'=>'图片尺寸必须是xx*yy~',
            'thumbnail.max'=>'不要上传超过2M的文件',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->errorBag = 'update-'.$this->route('project');
        parent::failedValidation($validator);
    }
}
