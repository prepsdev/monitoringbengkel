<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $technicians = Technician::with(['works'])->get();

        foreach ($technicians as $technician) {
            foreach ($technician->works as $work) {
                if ($work->waktu) {
                    try {
                        // Pastikan format waktu valid
                        $duration = Carbon::createFromFormat('H:i:s', $work->waktu);

                        $estimatedEndTime = Carbon::parse($work->created_at)
                            ->copy()
                            ->addHours($duration->hour)
                            ->addMinutes($duration->minute)
                            ->addSeconds($duration->second);

                        $work->estimated_end_time = $estimatedEndTime;
                        $work->remaining_seconds = now()->diffInSeconds($estimatedEndTime, false);
                    } catch (\Exception $e) {
                        $work->estimated_end_time = null;
                        $work->remaining_seconds = PHP_INT_MAX;
                    }
                } else {
                    $work->estimated_end_time = null;
                    $work->remaining_seconds = PHP_INT_MAX;
                }
            }

            // Sort berdasarkan estimated_end_time terdekat
            $technician->works = $technician->works
                ->sortBy(function ($work) {
                    return $work->estimated_end_time ?? now()->addYears(100);
                })
                ->values();
        }

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
        $work = Work::findOrFail($id);

        // Check if the status is 'Selesai', then we don't change the time
        if ($request->status == 'Selesai') {
            $newWaktu = $work->waktu;
        } else {
            // Ensure that the input time has seconds (default to '00' if missing)
            $newWaktu = $request->waktu;
            if (substr_count($newWaktu, ':') == 1) {
                // If the time does not have seconds, add ':00' to it
                $newWaktu .= ':00';
            }

            // Parse existing and new times as Carbon instances
            $existingTime = Carbon::createFromFormat('H:i:s', $work->waktu);
            $newTime = Carbon::createFromFormat('H:i:s', $newWaktu);

            // Add the new time to the existing time
            $newWaktu = $existingTime->addHours($newTime->hour)
                ->addMinutes($newTime->minute)
                ->addSeconds($newTime->second)
                ->format('H:i:s');
        }

        // Update the work record with the new time, status, and other fields
        $work->update([
            'waktu' => $newWaktu,
            'status' => $request->status,
            'note' => $request->note,
            'job_desc' => $request->job_desc,
        ]);

        // If the work is still 'Dalam Pengerjaan', calculate the new estimated end time
        if ($work->status == 'Dalam Pengerjaan') {
            $createdAt = Carbon::parse($work->created_at);

            // Parse the newWaktu as a Carbon instance to get hours, minutes, and seconds
            $newTime = Carbon::createFromFormat('H:i:s', $newWaktu);

            // Add the new time to created_at to get the estimated end time
            $estimatedEndTime = $createdAt->addHours($newTime->hour)
                ->addMinutes($newTime->minute)
                ->addSeconds($newTime->second)
                ->format('Y-m-d H:i:s');

            // Update the work with the calculated estimated end time
            $work->update(['estimated_end_time' => $estimatedEndTime]);
        }

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
