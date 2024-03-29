@extends('admin::layouts.master')
 
    @section('content') 
      @include('admin::partials.navigation')
      @include('admin::partials.breadcrumb')   

       @include('admin::partials.sidebar')  
      <div class="panel panel-white"> 

 
       <div class="panel panel-flat">
              <div class="panel-heading">
            <h6 class="panel-title"><b> {{$page_action??'List'}}</b>
                <br>
                <a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
            <div class="heading-elements">
              <ul class="icons-list">
                <li> <a type="button" href="{{route('adminUser')}}" class="btn btn-primary text-white   btn-rounded "> {{$heading??''}}<span class="legitRipple-ripple" ></span></a></li> 
              </ul>
            </div>
          </div> 
        </div>

                     <div class="panel-body">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar col-md-2">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet bordered">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <img src="{{ URL::asset('assets/img/user.png')}}" class="img-responsive" alt=""> </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{$user->first_name}} </div>
                                        <div class="profile-usertitle-job"> {{$user->position}} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->
                                    <!-- SIDEBAR BUTTONS -->
                                    <div class="profile-userbuttons">
                                        <button type="button" class="btn btn-circle green btn-sm">Email</button>
                                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                    </div>
                                    <!-- END SIDEBAR BUTTONS -->
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li>
                                                <a href="#">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li class="active">
                                                <a href="#">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                             
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="portlet light bordered">
                                    <!-- STAT -->
                                   
                                    <!-- END STAT -->
                                    <div>
                                        <h4 class="profile-desc-title"> {{$user->first_name}}</h4>
                                          <div class="row list-separated profile-stat">
                                      <!--   <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 37 </div>
                                            <div class="uppercase profile-stat-text"> Projects </div>
                                        </div> -->
                                        <!-- <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 0 </div>
                                            <div class="uppercase profile-stat-text"> Tasks </div>
                                        </div> -->
                                      <!--   <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 61 </div>
                                            <div class="uppercase profile-stat-text"> Uploads </div>
                                        </div> -->
                                    </div>
                                        <span class="profile-desc-text">{{$user->about_me}}</span>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-phone"></i>
                                            {{$user->phone}}
                                        </div>
                                       <!--  <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-twitter"></i>
                                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-facebook"></i>
                                            <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase"><b>User Account </b></span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                                    </li>
                                                    <!-- <li>
                                                        <a href="#tab_1_3" data-toggle="tab"> Business Info</a>
                                                    </li> -->
                                                  <!--   <li>
                                                        <a href="#tab_1_4" data-toggle="tab">  Payment Info</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                    {!! Form::model($user, ['route' => ['adminUser.store'],'class'=>'form-basic ui-formwizard user-form','id'=>'users_form']) !!}
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB --> 
                                                <div class="margin-top-10">
                                                    @if (count($errors) > 1000)
                                                      <div class="alert alert-danger">
                                                          <ul>
                                                              @foreach ($errors->all() as $error)
                                                                  <li>{!! $error !!}</li>
                                                              @endforeach
                                                          </ul>
                                                      </div>
                                                    @endif
                                                </div>

                                             @include('admin::users.adminUser.personel_info', compact('user'))


                                            <!-- END PERSONAL INFO TAB --> 
                                            @include('admin::users.adminUser.changeAvtar', compact('user'))
                                           
                                             {!! Form::close() !!} 
                                           
                                            <!-- END CHANGE AVATAR TAB -->
                                           
                                        </div>

                                    </div>
                                    </form>
                                </div>
                            </div>
                        
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
        
@stop