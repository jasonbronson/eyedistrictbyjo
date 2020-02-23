@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix"><div class="dashboard">
                <div class="personal-info">
                    <h3 class="sub-title">Personal Information</h3>
                    <ul class="field-list">
                        <li>
                            <span>First Name</span>
                            <span>{{$firstname}}</span>
                        </li>
                        <li>
                            <span>Last Name</span>
                            <span>{{$lastname}}</span>
                        </li>
                        <li>
                            <span>Email</span>
                            <span>{{$email}}</span>
                        </li>
                        <!--li>
                            <span>Newsletter</span>
                            <span>
                            <span class="active">Not Subscribed</span>
                            </span>
                        </li-->
                        <!--li>
                            <span>Password</span>
                            <span><a href="/account/edit/changepass/1/">Change Password</a></span>
                        </li-->
                    </ul>
                    <div class="buttons-set">
                        <a href="/account/edit/" class="button utility">Change Personal Information</a>
                    </div>
                </div>

                <h2 class="sub-title">Shipping Address</h2>
                <div class="addresses-list">
                    <div class="addresses-primary address-box">
                        <ul class="field-list">
                        <li>
                            <span>Company</span>
                            <span>{{$company}}</span>
                        </li>
                        <li>
                            <span>Street</span>
                            <span>{{$street1}}</span>
                        </li>
                        <li>
                            <span>Street 2</span>
                            <span>{{$street2}}</span>
                        </li>
                        <li>
                            <span>City</span>
                            <span>{{$city}}</span>
                        </li>
                        <li>
                            <span>State</span>
                            <span>{{$region_id}}</span>
                        </li>
                        <li>
                            <span>PostCode</span>
                            <span>{{$postcode}}</span>
                        </li>
                        <li>
                            <span>Country</span>
                            <span>{{$country_id}}</span>
                        </li>
                        <li>
                            <span>Telephone</span>
                            <span>{{$telephone}}</span>
                        </li>
                        <!--li>
                            <span>Newsletter</span>
                            <span>
                            <span class="active">Not Subscribed</span>
                            </span>
                        </li-->
                        <!--li>
                            <span>Password</span>
                            <span><a href="/account/edit/changepass/1/">Change Password</a></span>
                        </li-->
                    </ul>
                        
                    </div>
                    <div class="addresses-additional address-box">
                        <ol>
                        </ol>
                        <div class="buttons-set"><a href="/account/edit-shipping/" class="button utility">Change Address</a><p></p>
                        </div>
                    </div>
                    <script type="text/javascript">
                        //<![CDATA[
                        function deleteAddress(addressId) {
                            if(confirm('Are you sure you want to delete this address?')) {
                                window.location='/address/delete/form_key/TTGEiSnnPTmHTW4E/id/'+addressId;
                            }
                            return false;
                        }
                        //]]>
                    </script>
                </div></div>            </div>
    </div>
</div>


</div>


@include('footer')