@extends('home.master.master')

@section('content')
<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="username">Username (how your name will appear to other users on the site)</label>
                            <input class="form-control" id="username" type="text" placeholder="Enter your username" name="username">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group ( name)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="inputLastName">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter your last name" id="name">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (No Handphone)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="handphone">No Handphone</label>
                                <input class="form-control" id="handphone" type="text" placeholder="Enter your no handphone" name="handphone">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email address</label>
                            <input class="form-control" id="email" type="email" placeholder="Enter your email address" name="email">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (old password)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="old-password">Old password</label>
                                <input class="form-control" id="old-password" type="tel" placeholder="Enter your old password" name="old-password">
                            </div>
                            <!-- Form Group (new password)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="new-password">New passowrd</label>
                                <input class="form-control" id="new-password" type="text" name="new-password" placeholder="Enter your new password">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection