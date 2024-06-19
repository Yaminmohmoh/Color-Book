<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $user_type = Auth()->user()->usertype;

            if ($user_type === 'admin') {
                return view('admin.index');
            } else if ($user_type === 'user') {
                return view('home.index');
            }
        } else {
            return redirect()->back();
        }
    }

    public function CategoryPage()
    {

        $data = Category::all();
        return view('admin.category', compact('data'));
    }

    public function AddCategory(Request $request)
    {
        $data = new Category;
        $data->cart_title = $request->category;

        $data->save();

        return redirect()->back()->with('message', 'Category Added Successfully');
    }

    public function DeleteCart($id)
    {
        $data = Category::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'Category Deleted Successfull');
    }

    public function EditCategory($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function UpdateCategory(Request $request, $id)
    {
        $data = Category::find($id);
        $data->cart_title = $request->cart_name;
        $data->save();
        return redirect('/category_page')->with('message', 'Category updated Successful');
    }

    public function AddBooks()
    {
        $data = Category::all();

        return view('admin.add_book', compact('data'));
    }

    public function StoreBooks(Request $request)
    {
        $data = new Book;
        $data->title = $request->book_name;
        $data->auther_name = $request->auther_name;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->description = $request->description;
        $data->category_id = $request->category;

        $book_image = $request->file('book_img');
        $auther_image = $request->file('auther_img');
        // uploading image
        if ($book_image) {
            // Correct method name
            $book_image_name = time() . '.' . $book_image->getClientOriginalExtension();
            $request->file('book_img')->move('book', $book_image_name);
            $data->book_img = $book_image_name;
        }

        if ($auther_image) {
            // Correct method name
            $auther_image_name = time() . '.' . $book_image->getClientOriginalExtension();
            $request->file('auther_img')->move('auther', $auther_image_name);
            $data->auther_img = $auther_image_name;
        }
        $data->save();
        return redirect()->back()->with('message', 'Book added successfully');
    }
}
