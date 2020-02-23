@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix"><div class="dashboard">
              <form action="/account/edit/" method="post">
                <div class="personal-info">
                    <h3 class="sub-title">Personal Information</h3>
                    <ul class="field-list">
                        <li>
                            <span>First Name</span>
                            <span><input type="text" value="{{$firstname}}"></span>
                        </li>
                        <li>
                            <span>Last Name</span>
                            <span><input type="text" value="{{$lastname}}"></span>
                        </li>
                        <li>
                            <span>Email</span>
                            <span><input type="text" value="{{$email}}"></span>
                        </li>
                        <li>
                            <span>Password</span>
                            <span><input type="text" value=""></span>
                        </li>
                        <!--li>
                            <span>Newsletter</span>
                            <span>
                            <span class="active">Not Subscribed</span>
                            </span>
                        </li-->
                        
                    </ul>
                    <div class="buttons-set">
                        <a href="/account/edit/" class="button utility">Save</a>
                    </div>
                </div>
                </form>
                </div>            
                
                </div>
                
    </div>
</div>


</div>


@include('footer')