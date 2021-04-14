<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::with('kelas')->orderBy('Nim', 'desc')->paginate(5);
        return view('mahasiswas.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', compact('kelas'));
    }
    public function store(Request $request)
    {

    //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $Kelas = Kelas::find($request->get('Kelas'));

        //fungsi eloquent untuk menyimpan data mahasiswa
        $Mahasiswa = new Mahasiswa();
        $Mahasiswa->Nim = $request->get('Nim');
        $Mahasiswa->Nama = $request->get('Nama');
        $Mahasiswa->Jurusan = $request->get('Jurusan');
        $Mahasiswa->No_Handphone = $request->get('No_Handphone');
        $Mahasiswa->Email = $request->get('Email');
        $Mahasiswa->Tanggal_Lahir = $request->get('Tanggal_Lahir');

        $Kelas = new Kelas;
        $Kelas->id = $request->get('Kelas');

        $Mahasiswa->Kelas()->associate($Kelas); // FUngsi eloquent untuk menyimpan belongTo
        $Mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim', $Nim)->first();
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }
    public function edit($Nim)
    {

    //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit

        $Mahasiswa = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        $Kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'Kelas'));
    }
    public function update(Request $request, $Nim)
    {
    //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);
    //fungsi eloquent untuk menyimpan data mahasiswa
    $Mahasiswa = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
    $Mahasiswa->Nim = $request->get('Nim');
    $Mahasiswa->Nama = $request->get('Nama');
    $Mahasiswa->Jurusan = $request->get('Jurusan');
    $Mahasiswa->No_Handphone = $request->get('No_Handphone');
    $Mahasiswa->Email = $request->get('Email');
    $Mahasiswa->Tanggal_Lahir = $request->get('Tanggal_Lahir');
    $Mahasiswa->save();

    $Kelas = new Kelas;
    $Kelas->id = $request->get('Kelas');

    $Mahasiswa->Kelas()->associate($Kelas); // FUngsi eloquent untuk menyimpan belongTo
    $Mahasiswa->save();
    //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
        }
        public function destroy( $Nim)
        {
    //fungsi eloquent untuk menghapus data
            Mahasiswa::find($Nim)->delete();
            return redirect()->route('mahasiswas.index')
                -> with('success', 'Mahasiswa Berhasil Dihapus');
        }
        public function search(Request $request)
        {
            $mahasiswas = Mahasiswa::where('Nama', 'like', "%" . $request->keywords . "%")->paginate(5);
            return view('mahasiswas.search', compact('mahasiswas'));
        }

    //     public function show($Nim)
    // {
    //     //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
    //     $Mahasiswa = Mahasiswa::find($Nim);
    //     return view('mahasiswas.detail', compact('Mahasiswa'));
    // }
    };
