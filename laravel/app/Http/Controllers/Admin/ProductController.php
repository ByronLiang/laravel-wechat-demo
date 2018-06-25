<?php

namespace App\Http\Controllers\Admin;

use JSend;
use Illuminate\Http\Request;
// use App\Http\Requests\Admin\Request;
use App\Models\Catagory;
use App\Models\Author;
use App\Models\Product;
use App\Models\SampleFile;

class ProductController extends Controller
{
    public function getList()
    {
        $data = Product::with('author')->paginate();

        return JSend::success($data);
    }

    public function getEdit($productId)
    {
        $product = Product::find($productId);
        $product->type = [1,2];

        return JSend::success($product);
    }

    public function getCatagory()
    {
        $catagory = Catagory::select('id as value', 'name as label')->get();

        return JSend::success($catagory);
    }

    public function getAuthor()
    {
        $authors = Author::select('id as value', 'name as label')->get();

        return JSend::success($authors);
    }

    public function getSearch()
    {
        if (request('type') == 'catagory') {
            $data = Catagory::where('name', 'like', '%'.request('keyword').'%')
                ->select('id as value', 'name as label')
                ->get();
        } else if (request('type') == 'author') {
            $data = Author::where('name', 'like', '%'.request('keyword').'%')
                ->select('id as value', 'name as label')
                ->get();
        }

        return JSend::success($data);
    }

    public function postCreate(Request $request)
    {
        dd($request->all());
    }

    public function postUpdate(Request $request)
    {
        Product::find($request->product_id)
            ->update([
                'video' => $request->video,
            ]);
        // SampleFile::create([
        //     'product_id' => $request->product_id,
        //     'sample_id' => 'z2.5b25e29ce3d00468089a6b6d',
        //     'sample_key' => 'sample_1529208658823.mp4',
        // ]);
        return JSend::success();
    }
}
