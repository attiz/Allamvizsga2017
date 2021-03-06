<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Tanárok frissítése</title>
    <meta charset="utf-8">
    <link href="{{ asset('/css/adminStyle.css') }}" rel="stylesheet">
</head>
<body>
<div id="table">
    <div id="top">
        <h2>Új tanár hozzáadása</h2>
        @if ($message = Session::get('siker'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('siker') }}
            </div>
        @endif
        @if ($message = Session::get('hiba'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('hiba') }}
            </div>
        @endif
    </div>
</div>


<div id="tanarAdatok">
    <form action="{{ URL::to('addTanar') }}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="labelDiv">
            <label>Név</label>
            <input type="text" id="nev" contenteditable="true" name="nev"/>
        </div>
        <div class="labelDiv">
            <label>Tanszék</label>
            <input type="text" id="tanszek" contenteditable="true" name="tanszek"/>
        </div>
        <div class="labelDiv">
            <label>Funkció</label>
            <input type="text" id="funkcio" contenteditable="true" name="funkcio"/>
        </div>
        <div class="labelDiv">
            <label>Email</label>
            <input type="text" id="email" contenteditable="true" name="email"/>
        </div>
        <button type="submit" id="hozzaad">Hozzáad</button>
    </form>
</div>
</body>