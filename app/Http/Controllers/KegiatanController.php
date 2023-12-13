<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validatedData = $request->validate([
            "id_user" => ["required"],
            "tanggal" => ['required', 'date'],
            "kegiatan" => ['required'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai']
        ]);

        if ($kegiatan->kehadiran->tanggal != $validatedData['tanggal']) {
            $existingKehadiran = Kehadiran::where('id_user', $validatedData['id_user'])
                ->where('tanggal', $validatedData['tanggal'])
                ->first();

            if ($existingKehadiran) {
                //?? Jika kehadiran sudah ada pada tanggal yang sama, update kehadiran yang lama
                if ($kegiatan->kehadiran->kegiatan->count() > 1) {
                    $kegiatan->id_kehadiran = $existingKehadiran->id;
                    $kegiatan->save();
                    $kegiatan->kehadiran->delete();
                } else {
                    //?? Jika hanya ada satu kegiatan pada tanggal tersebut, hapus kehadiran yang lama
                    $kegiatan->id_kehadiran = $existingKehadiran->id;
                    $kegiatan->save();
                    $kegiatan->kehadiran->delete();
                }
            } else {
                //??: Jika kegiatan pada tanggal tersebut lebih dari satu, ubah id kehadiran
                if ($kegiatan->kehadiran->kegiatan->count() > 1) {
                    //?? Jika existing kehadiran belum ada
                    if ($existingKehadiran == null) {
                        $new_kehadiran = Kehadiran::create([
                            'id_user' => $validatedData['id_user'],
                            'tanggal' => $validatedData['tanggal']
                        ]);
                    }
                    $kegiatan->id_kehadiran = $new_kehadiran->id;
                    $kegiatan->save();
                } else {
                    //?? Jika kegiatan hanya satu pada tanggal tersebut, update tanggal kehadiran yang ada
                    $kegiatan->kehadiran->tanggal = $validatedData['tanggal'];
                    $kegiatan->kehadiran->save();
                }
            }
        }


        $jam_mulai = Carbon::parse($validatedData['jam_mulai']);
        $jam_selesai = Carbon::parse($validatedData['jam_selesai']);

        if ($jam_mulai->diffInMinutes($jam_selesai) <= env("MAX_JAM", 24) * 60) {
            $kegiatan->nama_kegiatan = $validatedData['kegiatan'];
            $kegiatan->jam_mulai = $validatedData['jam_mulai'];
            $kegiatan->jam_selesai = $validatedData['jam_selesai'];
            $kegiatan->save();
            return redirect()->back()->with("success", "Data kegiatan berhasl di ubah");
        }
        return redirect()->back()->withErrors("Jam tidak boleh melebihi " . env("MAX_JAM", 24) . " Jam");
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->kehadiran->kegiatan->count() == 1) {
            $kegiatan->kehadiran->delete();
        }
        $kegiatan->delete();
        return redirect()->back()->with("success", 'Data kegiatan berhasil dihapus!');
    }
}
