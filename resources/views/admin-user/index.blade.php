@extends('layouts.app')

@section('title', 'Admin User')

@section('header')
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-plus-circle tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg tw-mb-0">Admin User</h5>
        </div>
        <div class="">
            <x-create-button href="{{ route('admin-user.create') }}">
                <i class="fas fa-plus-circle tw-mr-1"></i>Create
            </x-create-button>
        </div>

    </div>

@endsection

@section('content')

    <x-card class="tw-mb-5">
        <table class="table table-bordered datable-tb">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Updated</th>
                    <th class="text-center no-sort no-search">Action</th>
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
                    url: "{{ route('admin-user-datable') }}",
                    data: function(d) {

                    }
                },
                columns: [{
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'name',
                        class: 'text-center'
                    },
                    {
                        data: 'email',
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
                    {
                        data: 'action',
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

            $(document).on('click', '.delete-button',
                function(event) {
                    event.preventDefault();

                    var url = $(this).data('url');


                    deleteDialog.fire().then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                success: function(response) {
                                    table.ajax.reload();
                                    toastr.success(response.message);
                                }
                            })
                        }
                    });

                })

        });
    </script>
@endpush
