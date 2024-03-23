<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Mail\SendMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return view('pages.category.data-category',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // dd($request->all());die();
        try {
            $category = Category::create([
                    'name' => $request->name,
                    'is_publish' => $request->is_publish

            ]);
            // return redirect()->route('category.index');
            Mail::to('tujuan@example.com')->send(new SendMail($category));

            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
            ], 200);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data: ' . $e->getMessage()
            ], 500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = Category::findOrFail($id);
        return view('pages.category.show-category',compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Category::findOrFail($id);
        return view('pages.category.edit-category',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Category::findOrFail($id);
        $update->name = $request->name;
        $update->is_publish = $request->is_publish;
        $update->save();

        if ($update) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Category::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus data.',
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }

    }
}
