@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix"><div class="dashboard">
                <div class="personal-info">
                    <h3 class="sub-title">Prescriptions</h3>
                    <p>Below is a copy of your uploaded prescription we have on file.</p>
                    <ul class="field-list">
                    <li>
                            <span>Prescription</span>
                            <span><a href='#'>Click here to download a copy</a></span>
                        </li>  
                    </ul>
                </div>
        </div>
    </div>
</div>


</div>


@include('footer')