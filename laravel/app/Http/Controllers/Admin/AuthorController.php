<?php

namespace App\Http\Controllers\Admin;

use JSend;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function getList()
    {
        $perPage = request('perPage') ?? 5;
        $datas = Author::paginate($perPage)
            ->appends(request()->all());

        return JSend::success($datas);
    }

    public function postCreate(Request $request)
    {
        Author::create([
            'name' => $request->name,
            'avatar' => $request->avatar,
            'introduction' => $request->introduction,
        ]);

        return JSend::success();
    }

    public function getEdit(Request $request)
    {
        $data = Author::find($request->id);

        return JSend::success($data);
    }

    public function putUpdate(Request $request)
    {
        Author::find($request->id)->update([
            'name' => $request->name,
            'avatar' => $request->avatar,
            'introduction' => $request->introduction
        ]);

        return JSend::success();
    }

    public function getDestory()
    {
        return JSend::success();
    }
}
