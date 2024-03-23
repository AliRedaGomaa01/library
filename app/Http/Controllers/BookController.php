<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::pluck('name', 'id')->toArray();
        return inertia('Book/Create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tags.*'  => ['required','exists:tags,id'],
            'titleAr' => ['required', 'string', 'max:255'],
            'titleEn' => ['required', 'string', 'max:255'],
            'descriptionAr' => ['required', 'string','max:2047'],
            'descriptionEn' => ['required', 'string','max:2047'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'numeric', 'min:0', 'unique:books,isbn'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'pdfFile' => ['required','file' ,'mimes:pdf', 'max:10240'],
        ]);
        try{
            DB::beginTransaction();
            //  saving book
            $book = new Book();
            $book->title = json_encode(['en' => $validated['titleEn'], 'ar' => $validated['titleAr']]);
            $book->description = json_encode(['en' => $validated['descriptionEn'], 'ar' => $validated['descriptionAr']]);
            $book->author = $validated['author'];
            $book->isbn = $validated['isbn'];
            if ($request->hasFile('pdfFile')) {
                $file = $request->pdfFile;
                $extension = $file->extension();
                $newName = time() . rand(100,10000) . '.' . $extension; 
                $path = $file->storeAs('pdf', $newName, 'public');
                $book->path = $path;
                $book->url = asset('storage/' . $path);
            }
            $book->save();
            //  saving tags  
            $tags = Tag::whereIn('id', $validated['tags'])->get();
            foreach ($tags as $tag) {
                $book->tags()->attach($tag);
            }
            //  saving images
            if ($request->hasFile('images')) {
                foreach ($request->images as $image) {
                    $file = $image;
                    $extension = $image->extension();
                    $newName = time() . rand(100,10000) . '.' . $extension; 
                    $path = $file->storeAs('images', $newName, 'public');
                    $book->images()->create([
                        'path' => $path,
                        'url' => asset('storage/' . $path),
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', __('Done Successfully.'));
        }
        catch (\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
