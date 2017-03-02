<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Diak;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class DiakController extends Controller
{
    public function showView()
    {
        return view('excel.importExportDiakok');
    }

    public function showLogin()
    {
        return view('login.loginDiak');
    }

    public function loginDiak(){
        session_start();
        $kod = Input::get("neptun");
        $result = DB::select( DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => $kod,
        ));
        $acces = $result[0]->ossz;

        if ($acces == 1){
            $_SESSION['neptunkod'] = $kod;
            $res = DB::select( DB::raw("SELECT Count(*) as ossz FROM valaszok WHERE neptunkod = :somevariable"), array(
                'somevariable' => $kod,
            ));
            $kitoltve=$res[0]->ossz;
            var_dump($kitoltve);
            return Redirect::to('selectTantargyak') -> with('neptunkod' , $kitoltve);

        }
        else{
            return back()->with('success','Nincs ilyen neptun kód!');
        }
    }

    public function addDiak(Request $request){
        $student = new diak;
        $student -> neptun = Input::get("neptunkod");
        $student -> szak_id = Input::get("szak_id");
        $result = DB::select( DB::raw("SELECT Count(*) as ossz FROM diak WHERE neptun = :somevariable"), array(
            'somevariable' => Input::get("neptunkod"),
        ));
        $acces = $result[0]->ossz;
        if ($acces == 1){
            return back()->with('error','Ez a neptun kod már létezik!');
        }
        $result2 = DB::select( DB::raw("SELECT Count(*) as ossz FROM szak WHERE id = :somevariable"), array(
            'somevariable' => Input::get("szak_id"),
        ));
        $letezik = $result2[0]->ossz;
        if ($letezik == 0){
            return back()->with('error','Nincsen ilyen szak!');
        }

        $student->save();

        return back()->with('success','Sikeres hozzaadas!');
    }

    public function importDiak(Request $request)
    {
        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data as $neptunkodok) {
                    if(!empty($neptunkodok)){
                        $insert[] = ['neptun' => $neptunkodok['hallgato_neptun_kodja']];
                    }
                }

                if(!empty($insert)){
                    Diak::insert($insert);
                    return back()->with('success','Sikeres!');
                }

            }
        }

        return back()->with('error','Valasszon ki egy fajlt!');
    }

    public function exportDiak(Request $request)
    {
        $data = Diak::get()->toArray();
        return Excel::create('neptunkodok', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download();
    }
}
