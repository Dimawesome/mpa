@extends('admin.index')

@section('title', trans('app.admin.dashboard'))

@section('header', trans('app.admin.dashboard'))

@section('content')
    <div class="admin-dashboard">
        <div class="col-md-12">
            <h3 class="text-purple form-group">
                Realizavimas
            </h3>
        </div>
        <div class="col-md-12 text-purple form-group">
            Naudojant pasirinktas technologijas buvo sukurtas modulinis puslapių administravimas. Vystant funkcionalumą
            buvo akcentuojami programos išeities kodo dinamiškumas bei autonomija
        </div>
        <div class="col-md-12">
            <h3 class="text-purple form-group">
                Integravimas
            </h3>
        </div>
        <div class="col-md-12 text-purple form-group">
            Pritaikant sukurtą funkcionalumo logiką bei numatytus papildinius, buvo atliktas modulinis puslapių
            administravimo integravimas į mano.lka.lt (Lietuvos karo akademija) sistemą
        </div>
        <div class="col-md-12">
            <h3 class="text-purple form-group">
                MPA aktualumas
            </h3>
        </div>
        @php
            $text = [
                'Karkasinių projektų populiarumas ir vieningos administravimo realizacijos trūkumas',
                'Modulinio puslapių administravimo dinamiškumas ir greita internetinės sistemos plėtra',
                'Modulinio administravimo integravimas į skirtingus karkasinius projektus',
                'Efektyvus sisteminių resursų išnaudojimas'
            ];
        @endphp
        @foreach($text as $key => $value)
            <div class="col-md-12">
                @include('helpers.form_control', [
                    'type' => 'checkbox',
                    'name' => "list-$key",
                    'value' => 1,
                    'checked' => true,
                    'label' => $value,
                    'disabled' => true
                ])
            </div>
        @endforeach
    </div>
@stop
