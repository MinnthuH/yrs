@extends('layouts.app')
@section('title', 'Wallet')
@section('wallet-page-active', 'active')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg tw-mb-0"> Wallet</h5>
        </div>
        <div class="">
            <!-- <x-create-button href="{{ route('user.create') }}">
                <i class="fas fa-plus-circle tw-mr-1"></i>Create
            </x-create-button> -->
        </div>

    </div>

@endsection

@section('content')

    <x-card class="tw-mb-5">
        <table class="table table-bordered datable-tb">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">User Name</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Updated</th>
                
                </tr>
            </thead>
        </table>

    </x-card>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            var table = new DataTable('.datable-tb', {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('wallet-datable') }}",
                    data: function(d) {

                    }
                },
                columns: [{
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'user_name',
                        class: 'text-center'
                    },
                    {
                        data: 'amount',
                        class: 'text-center'
                    },
                   
                    {
                        data: 'created_at',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        class: 'text-center'
                    },
                   

                ],
                order: [
                    [4, 'desc']
                ],
                columnDefs: [{
                        targets: 'no-sort',
                        orderable: false
                    },
                    {
                        targets: 'no-search',
                        searchable: false
                    },
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        className: 'control'

                    }
                ],
                responsive: {
                    detail: {
                        type: 'column',
                        target: 0
                    }
                }
            });

            

        });
    </script>
@endpush
