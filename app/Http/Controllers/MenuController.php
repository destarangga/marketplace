<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('merchant_id', Auth::id())->get();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $menu = new Menu();
    $menu->merchant_id = Auth::id();
    $menu->name = $request->name;
    $menu->description = $request->description;
    $menu->price = $request->price;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $file_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image/menu'), $file_name);
        
        $menu->image_path = $file_name;
    }

    $menu->save();
    return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
}

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $menu->name = $request->name;
    $menu->description = $request->description;
    $menu->price = $request->price;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $file_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image/menu'), $file_name);
        
        $menu->image_path = $file_name;
    }

    $menu->save();
    return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
}

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
