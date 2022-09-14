@extends('twill::layouts.settings')

@section('contentFields')
    @formField('input', [
    'label' => 'Seitenname',
    'name' => 'title',
    'translated' => true,
    'textLimit' => '80'
    ])
@stop
