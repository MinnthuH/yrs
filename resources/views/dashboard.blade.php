@extends('layouts.app')

@section('title', 'DashBoard')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-th tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg tw-mb-0">Dashboard</h5>
        </div>
        <div class=""></div>

    </div>

@endsection

@section('content')

    <x-card>
        <div class="tw-flex tw-justify-center tw-items-center tw-bg-theme">
            <img src="{{ asset('image/dashboard.png') }}" alt="" class="tw-w-4/12">
        </div>
        <p class="text-center">Welcome to {{ config('app.name') }}</p>
    </x-card>

@endsection
