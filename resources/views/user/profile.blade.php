@extends('layouts.dashboard')
@section('custom_head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('title', 'AChan - Profile')
@section('is_profile_active', 'active')
@section('content')
    <div class="header pb-6 d-flex align-items-center"
        style="min-height: 500px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <h1 class="display-2 text-white">Hello {{ $profile_data->first_name }}</h1>
                    <p class="text-white mt-0 mb-5">{{ ($profile_data->notes ? $profile_data->notes : "This is your profile page. You can see the progress you've made with
                        your work and manage your projects or assigned tasks") }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit profile </h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-primary" onclick="save()">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form name="inv_form" id="inv_form">
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="alert alert-dismissible fade" role="alert" id="message">

                            </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Username</label>
                                            <input type="hidden" name="id_user" value="{{ $profile_data->id_user }}">
                                            <input type="hidden" name="id_role" value="{{ $profile_data->id_role }}">
                                            <input type="text" id="username" name="username" class="form-control"
                                                placeholder="Username" value="{{ $profile_data->username }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email address</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="jesse@example.com" value="{{ $profile_data->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-first-name">First name</label>
                                            <input type="text" id="first_name" name="first_name" class="form-control"
                                                placeholder="First name" value="{{ $profile_data->first_name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Last name</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control"
                                                placeholder="Last name" value="{{ $profile_data->last_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <hr class="my-4" />
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Contact information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Address</label>
                                            <input id="input-address" class="form-control" placeholder="Home Address"
                                                value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-city">City</label>
                                            <input type="text" id="input-city" class="form-control" placeholder="City"
                                                value="New York">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" id="input-country" class="form-control" placeholder="Country"
                                                value="United States">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Postal code</label>
                                            <input type="number" id="input-postal-code" class="form-control"
                                                placeholder="Postal code">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <hr class="my-4" />
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">About me</h6>
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">About Me</label>
                                    <textarea name="notes" id="notes" rows="4" class="form-control"
                                        placeholder="A few words about you ...">{{ $profile_data->notes }}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

            function save() {
                let elements = document.getElementById("inv_form").elements;
                let xhttp = new XMLHttpRequest();
                let obj = {};
                for (let i = 0; i < elements.length; i++) {
                    let item = elements.item(i);
                    obj[item.name] = item.value;
                }

                xhttp.open("POST", "/user/save", true);
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
                                window.open('/user', '_self')
                        }
                    }
                };
            }
        </script>
    @endsection
