<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepotModel;

class DepotController extends Controller
{
    public function index(Request $request){
        $query = DepotModel::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', '%'.$search.'%');
        }
        $sort = in_array($request->get('sort'), ['name', 'price', 'quantity']) ? $request->get('sort') : 'name';
        $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sort, $direction);

        // Pagination
        $depots = $query->paginate(10)->appends($request->except('page'));

        return view('depots.index', compact('depots'));
    }

    public function destroy($id){
        $depot = DepotModel::findOrFail($id);
        $depot->delete();

        return redirect('/depots')->with('success', 'Xóa sản phẩm thành công.');
    }

    public function create(){
        return view("depots.create");
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        DepotModel::create($validated);

        return redirect('/depots')->with('success', 'Thêm sản phẩm thành công.');
    }
}
