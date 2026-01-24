<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Log;
class UnitController extends Controller
{
    public function index() {
        $units = Unit::latest()->get();
        return view('admin.units.index', compact('units'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:units']);
        Unit::create($request->all());
        return back()->with('success', 'Satuan berhasil ditambah');
    }

    public function update(Request $request) {
        Log::Info("UPDATE");
        $id = $request->id;
        $unit = Unit::findOrFail($id);
        Log::Info($unit);
        $unit->name = $request->name;
        $unit->short_name = $request->short_name;
        $unit->save();
        Log::Info("redirect");
        //return redirect()->route('admin.unit-list')->with('success', 'Satuan berhasil diupdate');
        return back()->with('success', 'Satuan berhasil diupdate');
    }

    public function destroy($id) {
        Unit::findOrFail($id)->delete();
        return back()->with('success', 'Satuan berhasil dihapus');
    }
}