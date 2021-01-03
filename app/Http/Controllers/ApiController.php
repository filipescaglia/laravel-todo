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

    public function show(int $id)
    {
        $response = ['error' => ''];

        $todo = Todo::find($id);

        if($todo) $response['result'] = $todo;
        else $response['error'] = "Task $id does not exists";

        return $response;
    }

    public function update(int $id, Request $request)
    {
        $response = ['error' => ''];

        $rules = [
            'title' => 'min:3',
            'done' => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $response['error'] = $validator->messages();
            return $response;
        }

        $title = $request->input('title');
        $done = $request->input('done');

        $todo = Todo::find($id);
        if($todo) {

            if($title) $todo->title = $title;
            if($done !== NULL) $todo->done = $done;

            $todo->save();

        } else $response['error'] = "Task $id does not exists";

        return $response;
    }

    public function delete(int $id)
    {
        $response = ['error' => ''];

        $todo = Todo::find($id);
        $todo->delete();

        return $response;
    }
}
