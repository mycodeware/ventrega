<?php

declare(strict_types=1);

namespace Modules\Admin\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Input;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Models\Roles;
use Modules\Admin\Models\User;
use Route;
use View;
use Session;

/**
 * Class SingleUsersController
 */
class SingleUsersController extends Controller
{
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('admin');
        View::share('viewPage', 'Users');
        View::share('helper', new Helper);
        View::share('heading', 'Users');
        View::share('route_url', route('user'));

        $this->record_per_page = Config::get('app.record_per_page');
        $this->indexUrl     = 'admin::users.singleUser.index';
        $this->createUrl    = 'admin::users.singleUser.create';
        $this->editUrl      = 'admin::users.singleUser.edit';
        $this->defaultUrl   = route('singleUser');
        $this->createMessgae = 'Record created successfully.';
        $this->updateMessage = 'Record updated successfully.';
        $this->deleteMessgae =  'Record deleted successfully.';
    }

    protected $users;

    /*
     * Dashboard
     * */

    public function index(User $user, Request $request)
    {
        $page_title  = ucfirst(Route::currentRouteName());
        $page_action = 'View '.ucfirst(Route::currentRouteName());

        if ($request->ajax()) {
            $id           = $request->get('id');
            $status       = $request->get('status');
            $user         = User::find($id);
            $s            = ($status == 1) ? $status=0:$status=1;
            $user->status = $s;
            $user->save();
            echo $s;

            exit();
        }
        // Search by name ,email and group
        $search    = Input::get('search');
        $status    = Input::get('status');
        $role_type = Input::get('role_type');

        if ((isset($search) && !empty($search)) or  (isset($status) && !empty($status)) or !empty($role_type)) {
            $search = isset($search) ? Input::get('search') : '';

            $users = User::where(function ($query) use ($search,$status,$role_type) {
                if (!empty($search)) {
                    $query->Where('first_name', 'LIKE', "%$search%")
                        ->OrWhere('last_name', 'LIKE', "%$search%")
                        ->OrWhere('email', 'LIKE', "%$search%");
                }

                if (!empty($status)) {
                    
                    $status =  ($status == 'active')?1:0;
                    $query->Where('status', $status);
                }

                if ($role_type) {
                    $query->Where('role_type', $role_type);
                }
            })->where('role_type', '=', 2)->Paginate($this->record_per_page);
        } else {
            $users = User::orderBy('id', 'desc')->where('role_type', '=', 2)->Paginate($this->record_per_page);
        }
        $roles = config('role');

        $js_file = ['common.js','bootbox.js','formValidate.js'];


        return view($this->indexUrl, compact('js_file', 'roles', 'status', 'users', 'page_title', 'page_action', 'roles', 'role_type'));
    }

    /*
     * create Group method
     * */

    public function create(User $user)
    {
        $page_title  =  str_replace(['.','create'],'', ucfirst(Route::currentRouteName()));
        $page_action =  str_replace('.',' ', ucfirst(Route::currentRouteName()));

        $roles       = Roles::all();
        $role_id     = null;
        $js_file     = ['common.js','bootbox.js','formValidate.js'];

        return view($this->createUrl, compact('js_file', 'role_id', 'roles', 'user', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(UserRequest $request, User $user)
    {
        $user->fill(Input::all());
        $user->password = Hash::make($request->get('password'));

        $action = $request->get('submit');

 
            if ($request->file('profile_image')) {
                $profile_image = User::createImage($request, 'profile_image');
                $request->merge(['profilePic' => $profile_image]);
                $user->profile_image = $request->get('profilePic');
            }
        
        $user->save();
        $js_file = ['common.js','bootbox.js','formValidate.js'];

        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->createMessgae);
    }

    /*
     * Edit Group method
     * @param
     * object : $user
     * */

    public function edit(User $user)
    {
        $page_title  =  str_replace(['.','edit'],'', ucfirst(Route::currentRouteName()));
        $page_action =  str_replace('.',' ', ucfirst(Route::currentRouteName()));

        $role_id     = $user->role_type;
        $roles       = Roles::all();
        $js_file     = ['common.js','bootbox.js','formValidate.js'];

        return view('admin::users.singleUser.edit', compact('js_file', 'role_id', 'roles', 'user', 'page_title', 'page_action'));
    }

    public function update(Request $request, User $user)
    {
        $user->fill(Input::all());

        if (!empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->fill(Input::all());
        $action          = $request->get('submit');
        $user->role_type = $request->get('role_type');

         
        if ($request->file('profile_image')) {
            $profile_image = User::createImage($request, 'profile_image');
            
            $request->merge(['profilePic' => $profile_image]);
            $user->profile_image = $request->get('profilePic');
        }


        $validator_email = User::where('email', $request->get('email'))
            ->where('id', '!=', $user->id)->first();

        if ($validator_email) {
            if ($validator_email->id == $user->id) {
                $user->save();
            } else {
                return  Redirect::back()->withInput()->with(
                    'field_errors',
                      'The Email already been taken!'
                 );
            }
        }
       
        $user->save(); 

        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->updateMessgae);
    }
    /*
     *Delete User
     * @param ID
     *
     */
    public function destroy(Request $request, $user)
    {
         $user->delete();
        return Redirect::to($this->defaultUrl)
            ->with('flash_alert_notice', $this->deleteMessgae);
    }

    public function show(User $user)
    {
    }
}
