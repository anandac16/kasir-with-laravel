@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datepicker3.css') }}" type="text/css">
    <script src="{{ URL::asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <style>
        .w-90 {
            width: 90% !important;
        }

    </style>
@endsection

@section('title', $title)
@section('is_unit_active', 'active')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Members</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Members</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Top up</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="#" class="btn btn-sm btn-neutral">New</a>
                        <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0 form-inline">
                        <div class="col-lg-6">
                            <h3 class="mb-0">{{ $title }}</h3>
                        </div>
                    </div>
                    <!-- Modal add inventory -->
                    <div class=" modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-dismissible fade" role="alert" id="message">

                                    </div>
                                    <form action="/unit/save" method="post" name="inv_form" id="inv_form">
                                        <div class="form-group form-inline">
                                            <input type="hidden" name="id_member" id="id_member" value="0">
                                            <div class="col-lg-4 text-right">No. Member</div>
                                            <div class="col-lg-8"><input type="text" name="no_member" id="no_member"
                                                    class="form-control w-90" readonly></div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <div class="col-lg-4 text-right">Nama Lengkap</div>
                                            <div class="col-lg-8"><input type="text" name="nama_lengkap" id="nama_lengkap"
                                                    class="form-control w-90" readonly></div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <div class="col-lg-4 text-right">Nominal</div>
                                            <div class="col-lg-8"><input type="number" name="points" id="points"
                                                    class="form-control w-90 text-right" required></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="save()">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="id">No</th>
                                    <th scope="col" class="sort" data-sort="no_member">No. Member</th>
                                    <th scope="col" class="sort" data-sort="nama_lengkap">Nama</th>
                                    <th scope="col" class="sort" data-sort="no_identitas">No. Identitas</th>
                                    <th scope="col" class="sort" data-sort="no_hp">No. HP</th>
                                    <th scope="col" class="sort" data-sort="tanggal_lahir">Tanggal Lahir</th>
                                    <th scope="col" class="sort" data-sort="points">Points</th>
                                    <th scope="col" width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($data as $key => $member)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $member->no_member }}
                                        </td>
                                        <td>
                                            {{ $member->nama_lengkap }}
                                        </td>
                                        <td>
                                            {{ $member->no_identitas }}
                                        </td>
                                        <td>
                                            {{ $member->no_hp }}
                                        </td>
                                        <td>
                                            {{ $member->tanggal_lahir }}
                                        </td>
                                        <td align="center">
                                            {{ number_format($member->points, 2) }}
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item"
                                                        onclick="edit({{ $member->id_member }}, '{{ $member->no_member }}', '{{ $member->nama_lengkap }}')"
                                                        data-id="{{ $member->id_member }}">Top up</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#message").hide();
            $("#tanggal_lahir").datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
            });
            const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            function edit(id, no_member, nama_lengkap) {
                $("#id_member").val(id);
                $("#no_member").val(no_member);
                $("#nama_lengkap").val(nama_lengkap);
                $("#exampleModal").modal('show');
            }

            function save() {
                let elements = document.getElementById("inv_form").elements;
                let xhttp = new XMLHttpRequest();
                let obj = {};
                for (let i = 0; i < elements.length; i++) {
                    let item = elements.item(i);
                    obj[item.name] = item.value;
                }

                xhttp.open("POST", "/member/topup/save", true);
                xhttp.setRequestHeader("X-CSRF-TOKEN", csrf_token);
                xhttp.send(JSON.stringify(obj));

                xhttp.onreadystatechange = function() {
                    // If the request completed, close the extension popup
                    if (xhttp.readyState == 4) {
                        if (xhttp.status == 200) {
                            let json_data = JSON.parse(xhttp.responseText);
                            let class_type = 'alert-success'
                            if (json_data.result === false)
                                class_type = 'alert-danger'
                            $("#message").removeClass('fade alert-danger alert-success');
                            $("#message").addClass(class_type + " show");
                            $("#message").html(json_data.message);
                            $("#message").removeAttr("style");
                            $(".alert").fadeTo(3000, 0).slideUp(1000);
                            if (json_data.result === true)
                                window.open('/member/topup', '_self')
                        }
                    }
                };
            }
        </script>
    @endsection
