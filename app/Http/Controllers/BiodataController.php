<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\checkup;
use Illuminate\Support\Carbon;
use DateTime;
use DateInterval;

class BiodataController extends Controller
{
    // Fungsi untuk menghitung HPL
    private function hitungHPL($tglHPHT)
    {
        $tglHPHTDate = DateTime::createFromFormat('Y-m-d', $tglHPHT);
        $hpl = $tglHPHTDate->add(new DateInterval('P280D'));
        return $hpl->format('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $biodata = Biodata::with('subjektif')->paginate(10);
        //dd($biodata);

        foreach ($biodata as $data) {
            $subjektif = $data->subjektif;
            if ($subjektif) {
                $tglHPHT = $subjektif->HPHT;
                $hplFormat = $this->hitungHPL($tglHPHT);
                $subjektif->HPL = $hplFormat;
            }
        }

        return view('biodata', compact('biodata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('form_tambah_biodata');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the request

        //tambah data
        Biodata::create([
            'nama' => $request->inputnama,
            'umur' => $request->inputumur,
            'agama' => $request->inputagama,
            'pendidikan' => $request->inputpendidikan,
            'pekerjaan' => $request->inputpekerjaan,
            'alamat' => $request->inputalamat,
            'nomer_tlpn' => $request->inputnomer,
            'nama_suami' => $request->inputnama_suami,
            'umur_suami' => $request->inputumur_suami,
            'agama_suami' => $request->inputagama_suami,
            'pendidikan_suami' => $request->inputpendidikan_suami,
            'pekerjaan_suami' => $request->inputpekerjaan_suami,
            'alamat_suami' => $request->inputalamat_suami,
            'nomer_suami' => $request->inputnomer_suami,
        ]);

        return redirect('/biodata')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $biodata = Biodata::with(['subjektif', 'checkup'])->find($id);

        if ($biodata) {
            $subjektif = $biodata->subjektif;
            if ($subjektif) {
                $tglHPHT = $subjektif->HPHT;
                $hplFormat = $this->hitungHPL($tglHPHT);
                $subjektif->hpl = $hplFormat;
            }

            $checkupData = Checkup::where('biodata_id', $id)->pluck('berat');
            //dd($checkupData);

            $tanggal = Checkup::where('biodata_id', $id)->pluck('tgl');
            //dd($tgl);

            $tgl = $tanggal->map(function ($date) {
                return Carbon::parse($date)->translatedFormat('d-m-Y');
            });
            //dd($tgl);

            return view('profil_biodata', compact('biodata', 'checkupData', 'tgl'));
        } else {
            abort(404); // Data biodata tidak ditemukan, tampilkan halaman 404
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //mengambil data
        $biodata = Biodata::where('id', $id)->first();
        //dd($biodata);
        // passing data ke view
        return view('form_ubah_biodata', ['biodata' => $biodata]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $biodata = Biodata::find($id);
        $biodata->nama = $request->inputnama;
        $biodata->umur = $request->inputumur;
        $biodata->agama = $request->inputagama;
        $biodata->pendidikan = $request->inputpendidikan;
        $biodata->pekerjaan = $request->inputpekerjaan;
        $biodata->alamat = $request->inputalamat;
        $biodata->nomer_tlpn = $request->inputnomer;
        $biodata->nama_suami = $request->inputnama_suami;
        $biodata->umur_suami = $request->inputumur_suami;
        $biodata->agama_suami = $request->inputagama_suami;
        $biodata->pendidikan_suami = $request->inputpendidikan_suami;
        $biodata->pekerjaan_suami = $request->inputpekerjaan_suami;
        $biodata->alamat_suami = $request->inputalamat_suami;
        $biodata->nomer_suami = $request->inputnomer_suami;
        $biodata->save();
        return redirect('/biodata')->with(['edit' => 'Data Telah Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $biodata = Biodata::findOrFail($id);
        $biodata->delete();

        return redirect('/biodata')->with(['delete' => 'Data Telah Dihapus']);
    }

    public function search(Request $request)
    {
        $cari = $request->input('cari');
        $biodata = Biodata::where('nama', 'LIKE', "%$cari%")->get();

        return view('biodata', compact('biodata'));
    }
}
