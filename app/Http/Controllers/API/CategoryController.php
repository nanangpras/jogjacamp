<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getAll()
    {
        $category = Category::select('id', 'name','is_publish')->get();
        return ResponseFormat::success(
            $category
        ,'Successful get category');
    }

    public function detail($id)
    {
        try {
            $detail = Category::findOrFail($id);
            return ResponseFormat::success(
                $detail,
            'Successful get detail category');
            //code...
        } catch (\Exception $e) {
            //throw $th;
            return ResponseFormat::error('Error get detail category' . $e->getMessage());
        }
    }

    public function insert(CategoryRequest $request)
    {
        try {
            $check = Category::where('name', $request->name)->exists();

            if ($check) {
                return ResponseFormat::error('Category already exists');
            }else{
                $category = Category::create([
                    'name' => $request->name,
                    'is_publish' => $request->is_publish
                ]);
                return ResponseFormat::success($category,'Successful category insert');
            }

        } catch (\Exception $e) {
            return ResponseFormat::error([
                'message' => 'Error Inserting category',
                'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function update(CategoryRequest $request,$id)
    {
        try {
            $update = Category::findOrFail($id);
            $update->name = $request->name;
            $update->is_publish = $request->is_publish;
            $update->save();

            return ResponseFormat::success(
                $update,
            'Successful category update');

        } catch (\Exception $e) {
            return ResponseFormat::error([
                'message' => 'Error Updating category',
                'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function delete($id)
    {
        try {
            $data = Category::findOrFail($id);
            $data->delete();
            return ResponseFormat::success('Successful category delete');

        } catch (\Exception $e) {
            return ResponseFormat::error([
                'message' => 'Error Deleting category',
                'error' => $e->getMessage(),
                ]
            );
        }
    }
}
