<div class="tab-pane active" id="tab_1_1"> 
<div class="portlet light bordered">
 
   
    <div class="form-group {{ $errors->first('first_name', ' has-error') }}">
        <label class="control-label">First Name</label>
        <input type="text" placeholder="First Name" class="form-control" name="first_name" 
        value="{{ ($user->first_name)?$user->first_name:old('first_name')}}"> </div>
    <div class="form-group {{ $errors->first('last_name', ' has-error') }}" >
        <label class="control-label">Last Name</label>
        <input type="text" placeholder="Last Name" class="form-control" name="last_name" value="{{ ($user->last_name)?$user->last_name:old('last_name')}}">  
    </div>
     <div class="form-group {{ $errors->first('email', ' has-error') }}">
        <label class="control-label ">Email</label>
        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ ($user->email)?$user->email:old('email')}}"> 
    </div>
    <div class="form-group {{ $errors->first('password', ' has-error') }}">
        <label class="control-label">Password</label>
        <input type="password" placeholder="******" class="form-control" name="password"> 
    </div>

     <input type="hidden" value="{{$role_id}}" name="role_type">
    
      <div class="form-group {{ $errors->first('phone', ' has-error') }}">
        <label class="control-label">Mobile Number</label>
        <input type="text" placeholder="Mobile or Phone" class="form-control phone" name="phone"  value="{{ ($user->phone)?$user->phone:old('phone')}}"> </div>
 
    <div class="form-group {{ $errors->first('about_me', ' has-error') }}">
        <label class="control-label">About</label>
        <textarea class="form-control" rows="3" placeholder="Basic detail" name="about_me">{{$user->about_me}}</textarea>
    </div>
    
          
    <div class="margin-top-10"> 
         <button type="submit" class="btn green btn-primary" value="avtar" name="submit"> Save Changes </button>
        <button type="submit" class="btn default"> Cancel </button>
    </div>      
             
</div>
</div>
 