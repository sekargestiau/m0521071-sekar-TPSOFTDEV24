<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Books;
use App\Models\Author;
use App\Models\Category;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function index_create_books()
    {
       
        return view('admin.create-books');
    }

    public function index_create_author()
    {
       
        return view('admin.create-author');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function store_books(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'publication' => ['required', 'string'],
            'category' => ['required', 'string'],
            'sinopsis' => ['required', 'string'],
            'book_photo' => ['nullable'],
        ]);

        // send error message
        // send error message
        if (!$validated) {
            return redirect()->back()->with('error', 'Validation failed!');
        }

        if($request->file('book_photo')) {
            $fileName = time().'_'.$request->file('book_photo')->getClientOriginalName();
            $request->file('book_photo')->move(public_path('book_photo'), $fileName);
            $filePath = 'book_photo/'.$fileName;

            $validated['book_photo'] = $filePath;
        }

        // create book
        Books::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publisher' => $validated['publisher'],
            'publication' => $validated['year'],
            'category' => $validated['category'],
            'book_photo' => $validated['book_photo'],
            
        ]);

        // send success message
        return redirect('data-buku')->with('success2', 'Data Buku Berhasil Ditambahkan!');
    }

    public function store_books2(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'publication' => ['required', 'string'],
            'category' => ['required', 'string'],
            'book_photo' => ['nullable'],
        ]);

        // send error message
        // send error message
        if (!$validated) {
            return redirect()->back()->with('error', 'Validation failed!');
        }

        if($request->file('book_photo')) {
            $fileName = time().'_'.$request->file('book_photo')->getClientOriginalName();
            $request->file('book_photo')->move(public_path('book_photo'), $fileName);
            $filePath = 'book_photo/'.$fileName;

            $validated['book_photo'] = $filePath;
        }

        // create user
        Books::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publication' => $validated['publication'],
            'year' => $validated['year'],
            'category' => $validated['category'],
            'book_photo' => $validated['book_photo'],            
        ]);

        // send success message
        return redirect('data-buku')->with('success2', 'Data Buku Berhasil Ditambahkan!');

    }

    public function store_author(Request $request)
    {
        $validated = $request->validate([
            'author_name' => ['required', 'string'],
        ]);

        // send error message
        if (!$validated) {
            return redirect()->back()->with('error', 'Validation failed!');
        }


        // create author
        Author::create([
            'author_name' => $validated['author_name'],
        ]);

        // send success message
        return redirect('data-author')->with('success2', 'Author created!');
    }


    public function store_category(Request $request)
    {
        $validated = $request->validate([
            'category' => ['required', 'string'],
        ]);

        // send error message
        if (!$validated) {
            return redirect()->back()->with('error', 'Validation failed!');
        }


        // create category
        Category::create([
            'category' => $validated['category'],
        ]);

        // send success message
        return redirect('data-category')->with('success2', 'Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function show_books(Request $request)
    {
        $keyword = $request->keyword;

        $books = Books::where(function ($query) use ($keyword) {
            $query->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('author', 'LIKE', '%' . $keyword . '%')
                ->orWhere('publisher', 'LIKE', '%' . $keyword . '%')
                ->orWhere('publication', 'LIKE', '%' . $keyword . '%')
                ->orWhere('category', 'LIKE', '%' . $keyword . '%');
                
        })
        ->paginate(10);

        $books->withPath('data-buku');
        $books->appends($request->all());

        return view('admin.data-buku', compact('books', 'keyword'));
    }

    public function show_author(Request $request)
    {
        $keyword = $request->keyword;

        $author = Author::where(function ($query) use ($keyword) {
            $query->where('author_name', 'LIKE', '%' . $keyword . '%');
        })
        ->paginate(10);
        
        $author->withPath('data-author');
        $author->appends($request->all());

        return view('admin.data-author',compact('author','keyword'));
    }

    public function show_category(Request $request)
    {
        $keyword = $request->keyword;

        $category = Category::where(function ($query) use ($keyword) {
            $query->where('category', 'LIKE', '%' . $keyword . '%');
        })
        ->paginate(10);
        
        $category->withPath('data-category');
        $category->appends($request->all());

        return view('admin.data-category',compact('category','keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function edit_books(string $id)
    {
        $model = Books::find($id);
        return view('admin.edit-books', compact('model'));
    }



    /*
     * Update the specified resource in storage.
     */
    public function update_books(Request $request, string $id)
    {
        
        $model = Books::find($id);
        $model->title = $request->title;
        $model->author = $request->author;
        $model->publisher = $request->publisher;
        $model->publication = $request->publication;
        $model->category = $request->category;
        $model->book_photo = $request->book_photo;
        $model->save();

        return redirect('data-buku')->with('success3', 'Data Buku Berhasil Diperbarui!');
    }

    public function edit_author(string $id)
    {
        $model = Author::find($id);
        return view('admin.edit-author', compact('model'));
    }

    /*
     * Update the specified resource in storage.
     */
    public function update_author(Request $request, string $id)
    {
        
        $model = Author::find($id);
        $model->author_name = $request->author_name;
        $model->save();

        return redirect('data-author')->with('success', 'Data Author Berhasil Diperbarui!');
    }

    public function edit_category(string $id)
    {
        $model = Category::find($id);
        return view('admin.edit-category', compact('model'));
    }

    /*
     * Update the specified resource in storage.
     */
    public function update_category(Request $request, string $id)
    {
        
        $model = Category::find($id);
        $model->category = $request->category;
        $model->save();

        return redirect('data-category')->with('success', 'Data Category Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function destroy_author(string $id)
    {
        Author::findOrFail($id)->delete();

        return redirect('data-author')->with('success', 'Data berhasil dihapus');
    }

    public function destroy_books(string $id)
    {
        Books::findOrFail($id)->delete();
    
        return redirect('data-buku')->with('success', 'Data berhasil dihapus');
    }

    public function destroy_category(string $id)
    {
        Category::findOrFail($id)->delete();

        return redirect('data-category')->with('success', 'Data berhasil dihapus');
    }


}
