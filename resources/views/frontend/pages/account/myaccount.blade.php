@extends('frontend.pages.account.account')

@section('title','Account Uset || Dashboard')

@section('account-content')
<div >
    <div class="card">
        <div class="card-header">
            <h5>Account Details</h5>
        </div>
        <div class="card-body">
            <p>Already have an account? <a href="page-login.html">Log in instead!</a></p>
            <form method="post" name="enq">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Full Name <span class="required">*</span></label>
                        <input required="" class="form-control" name="dname" type="text" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email Address <span class="required">*</span></label>
                        <input required="" class="form-control" name="email" type="email" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Current Password <span class="required">*</span></label>
                        <input required="" class="form-control" name="password" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>New Password <span class="required">*</span></label>
                        <input required="" class="form-control" name="npassword" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Confirm Password <span class="required">*</span></label>
                        <input required="" class="form-control" name="cpassword" type="password" />
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection