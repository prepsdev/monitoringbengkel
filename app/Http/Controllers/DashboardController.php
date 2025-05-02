<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\Work;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $technicians = Technician::with(['works' => function ($query) {
            $query->orderByDesc('id');
        }])->get()
            ->sortByDesc(function ($tech) {
                return optional($tech->works->first())->id ?? 0;
            })
            ->sortBy('status');

        return view('dashboard', compact('technicians'));
    }

    public function storeWork(Request $request)
    {
        $request->validate([
            'no_spp' => 'required|string',
            'plat_nomor' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'jenis_pekerjaan' => 'required|string',
            'waktu' => 'required',
            'tanggal' => 'required|date',
            'technicians' => 'required|array',
        ]);

        $work = Work::create(array_merge(
            $request->only(['no_spp', 'plat_nomor', 'jenis_kendaraan', 'jenis_pekerjaan', 'waktu', 'tanggal', 'job_desc']),
            [
                'status' => 'Dalam Pengerjaan',
            ]
        ));

        $work->technicians()->attach($request->technicians);

        return redirect()->back()->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function updateWork(Request $request, $id)
    {
        $request->validate([
            'waktu' => 'required',
            'status' => 'required',
        ]);

        $work = Work::findOrFail($id);
        $work->update([
            'waktu' => $request->waktu,
            'status' => $request->status,
            'note' => $request->note,
            'job_desc' => $request->job_desc,
        ]);

        return back()->with('success', 'Pekerjaan berhasil diperbarui.');
    }


    public function storeTech(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Technician::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Technician added succesfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $technician = Technician::findOrFail($id);

        $technician->status = $request->status;
        $technician->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
