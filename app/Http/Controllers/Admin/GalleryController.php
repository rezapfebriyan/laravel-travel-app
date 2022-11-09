<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\ { Gallery, TravelPackage };

class GalleryController extends Controller
{
    public function index()
    {
        $items = Gallery::with(['travel_package'])->get();

        return view('pages.admin.gallery.index',[
            'items' => $items,
        ]);
    }

    public function create()
    {
        $travel_packages = TravelPackage::all();
        return view('pages.admin.gallery.create',[
            'travel_packages' => $travel_packages
        ]);
    }

    public function store(GalleryRequest $request)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store(
            'assets/gallery', 'public'
        ); //* simpan di public

        Gallery::create($data);

        return redirect()->route('gallery.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = Gallery::findOrFail($id);
        $travel_packages = TravelPackage::all();

        return view('pages.admin.gallery.edit',[
            'item' => $item,
            'travel_packages' => $travel_packages
        ]);
    }

    public function update(GalleryRequest $request, $id)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store(
            'assets/gallery', 'public'
        );

        $item = Gallery::findOrFail($id);
        $item->update($data);

        return redirect()->route('gallery.index');
    }

    public function destroy($id)
    {
        $item = Gallery::findorFail($id);
        $item->delete();

        return redirect()->route('gallery.index');
    }
}
