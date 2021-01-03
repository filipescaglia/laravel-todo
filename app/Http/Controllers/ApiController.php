<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        $response = ['error' => ''];

        $rules = [
            'title' => 'required|min:3'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $response['error'] = $validator->messages();
            return $response;
        }

        $title = $request->input('title');

        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        return $response;
    }

    public function index()
    {
        $response = ['error' => ''];

        $response['result'] = Todo::all();

        return $response;
    }

    public function show()
    {
        
    }

    public function update()
    {
        
    }

    public function delete()
    {
        
    }
}
