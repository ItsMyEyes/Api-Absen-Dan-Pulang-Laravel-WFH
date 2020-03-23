<?php

namespace App\Http\Controllers;

use App\Absen;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = \App\DataAbsen::where('nip',$request->nip)->first();
        if (!empty($check)) {
            if (\Crypt::decrypt($check->password) == $request->password) {
                $absen = Absen::where('tanggal',date('Y-m-d'))->where('id_login',$check->id)->get();
                if ($absen->count() < 1) {
                    $c = new Absen;
                    $c->id_login = $check->id;
                    $c->tanggal = date('Y-m-d');
                    $c->jam_masuk = strtotime(date('H:i:s'));
                    $c->save();
                    return response()->json([
                        'message' => 'Anda Berhasil Absen '.date('H:i:s'),
                        'code' => 200
                    ],200);   
                }else{
                    return response()->json([
                        'message' => 'Anda Sudah Absen Masuk Pukul '.date('H:i:s',$absen[0]->jam_masuk),
                        'code' => 402
                    ],402);
                }
            }else{
                return response()->json([
                    'code' => 403,
                    'message' => 'Gagal Absen Dikarenakan Salah Password'
                ],403);
            }
        }else{
            return response()->json([
                'message' => 'Nip Tidak Ditemukan',
                'code' => 402
            ],402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absen  $Absen
     * @return \Illuminate\Http\Response
     */
    public function show($Absen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absen  $Absen
     * @return \Illuminate\Http\Response
     */
    public function edit($Absen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absen  $Absen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $check = \App\DataAbsen::where('nip',$request->nip)->first();
        if (\Crypt::decrypt($check->password) == $request->password) {
            $absen = Absen::where('tanggal',date('Y-m-d'))->where('id_login',$check->id)->first();
            if ($absen->jam_pulang == null) {
                $c = Absen::where('tanggal',date('Y-m-d'))->where('id_login',$check->id)->first();
                $c->tanggal = date('Y-m-d');
                $c->jam_pulang = strtotime(date('H:i:s'));
                $c->save();
                return response()->json([
                    'message' => 'Anda Berhasil Absen Pulang '.date('H:i:s'),
                    'code' => 200
                ],200);   
            }else{
                return response()->json([
                    'message' => 'Anda Sudah Absen Pulang Pukul '.date('H:i:s',$absen->jam_pulang),
                    'code' => 402
                ],402);
            }
        }else{
            return response()->json([
                'code' => 403,
                'message' => 'Gagal Absen Dikarenakan Tidak Ada Nip Anda'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absen  $Absen
     * @return \Illuminate\Http\Response
     */
    public function destroy($Absen)
    {
        //
    }
}
