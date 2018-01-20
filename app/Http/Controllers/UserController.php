<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Exports\UserExport;
use App\Imports\UserImport; 

use App\Models\User;
use App\Models\Role;
use App\Models\JemaatInduk;
use App\Models\Profile;

use Validator;
use \Carbon\Carbon;
use DB;
use Gate;
use Form;
use Auth;
use Hash;
use Excel;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware(function($request, $next) {
            $this->userSession = Auth::user();
    
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( Gate::denies('show-user') )
            return abort(401);

        $models = User::orderBy('id', 'desc')->simplePaginate(10);

        $this->viewData['users'] = $models;
        $this->viewData['page_title'] = 'List User';

        return view('users.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( Gate::denies('create-user') )
            return abort(401);

        $this->viewData['page_title'] = 'Data Users';
        $this->viewData['list_roles'] = Role::pluck('name', 'id')->all();

		return view('users.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( \App\Http\Requests\CreateUserRequest $request)
    {
        $request->validated();
        $validatedData = $request->formatInput();
        // dd( $validatedData );

        $userEntityExceptionKeys = ['id_role', 'mupel', 'jemaat', 'access_data'];
        $userEntityData = array_diff_key($validatedData, array_flip($userEntityExceptionKeys));
        // dd( $userEntityData );
        

        $lastUser = User::create($userEntityData);
        $nowTime = new Carbon();
        $lastUser->roles()->attach($validatedData['id_role'], ['created_at' => $nowTime, 'updated_at' => $nowTime]);

        $profileData = [];
        $profileData['id_user'] = $lastUser->id;
        $profileData['access_data'] = $validatedData['access_data'];
        $userProfile = Profile::create($profileData);

        return redirect()->route('users.index')->with('status', 'Data User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( Gate::denies('show-user') )
            return abort(401);

        $user = User::findOrFail($id);
        $this->viewData['page_title'] = "Jemaat $user->name";
        $this->viewData['user'] = $user;

        return view('users.show', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( Gate::denies('update-user') )
            return abort(401);

        $user = User::findOrFail($id);

        $this->viewData['user'] = $user;
        $this->viewData['page_title'] = 'Data Credential User';

        return view('users.edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( Gate::denies('update-user') )
            return abort(401);

        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // 'password' => 'required|min:6',
            'password_baru' => 'string|min:6|confirmed',
            'password_baru_confirmation' => 'min:6'
        ], [
            'required' => 'The :attribute field is required',
            'numeric' => 'The :attribute field must only be letters and numbers (no spaces)'
        ]);

        $data = $request->except('file');

        unset($data["_token"]);

        $user->password = bcrypt($request->get('password_baru'));
        $user->pass_prompt = "1";
        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Data User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( Gate::denies('delete-user') )
            return abort(401);

        $user = User::findOrFail($id);

        $user->roles()->detach($user->roles()->first()->id);

        $user->delete();

        return redirect()->back()->with('status', 'Data user berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $criteria = [];
        $qSearchKey = $request->get('search_key');
        $qCategory = $request->get('category');

        if ( $qCategory == User::FIELD_EMAIL_FILTER ) {
            $criteria = ['users.email' => $qSearchKey];
        }

        $searchResult = User::search($qSearchKey, $criteria)->simplePaginate(10);

        $this->viewData['users'] = $searchResult;
        $this->viewData['page_title'] = 'List Aset Jemaat';

        return view('users.index', $this->viewData);
    }

    public function displayUserGuide()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path(). "/downloads/user-guide-jemaat.pdf";

        $headers = [
                    'Content-Type: application/pdf',
                ];

        return response()->file($file, $headers);
    }

    public function downloadUserGuide()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path(). "/downloads/user-guide-jemaat.pdf";

        $headers = [
                    'Content-Type: application/pdf',
                ];

        return response()->download($file, 'user-guide.pdf', $headers);
    }

    public function importUser(Request $request)
    {
        //$currentUser = current_user();
        //$input = $request->all(); //dd($input);
        $input = $request->only(['file']); //dd($input);


        if ( !empty($input['file']) ) {
            // Kalau file excel sudah diupload
            Excel::import(new UserImport, $input['file']);
            return redirect('users/import')->with('success', 'All good!');
        }

        $this->viewData['page_title'] = "Form Import User";
        return view('users.import', $this->viewData);
    }

    public function showGenerateUserRandomPassword()
    {
        return view('users.show-generate-user-random-pass', ['page_title' => "Generate random password untuk semua user"]);
    }

    public function generateUserRandomPassword()
    {
        // dd(Str::random() );
        $allUserExceptAdmin = User::all();
        $usersArr = [];
        foreach ($allUserExceptAdmin as $row) {
            if ( @$row->roles()->first()->name != "Admin" ) {
                // Dynamically add properties
                $row->randomPass = Str::random();
                // $row->update(['email' => 'mario.fredrick@tnisiber.id' ]);
                $row->update(['password' => bcrypt( $row->randomPass ) ]);
                // dd($row->randomPass);
                // $row->random_pass = $row->randomPass;
                $usersArr[] = $row;
            }
        }

        $userCollections = collect($usersArr);

        // Excel::create('user_pass', function($excel) use ($usersArr) {

        //     // Set the spreadsheet title, creator, and description
        //     $excel->setTitle('Payments');
        //     $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
        //     $excel->setDescription('payments file');
    
        //     // Build the spreadsheet, passing in the payments array
        //     $excel->sheet('sheet1', function($sheet) use ($usersArr) {
        //         $sheet->fromArray($paymentsArray, null, 'A1', false, false);
        //     });
    
        // })->download('xlsx');

        return Excel::download(new UserExport($userCollections), 'user-passwords.xlsx');
    }

    public function profile($id)
    {
        if ( Gate::denies('update-user') )
            return abort(401);

        $user = User::findOrFail($id);
        $user->id_role = $user->roles()->first()->id;

        $userProfile = $user->profile()->first();

        if ($userProfile) {
            $this->viewData['user_profile'] = $userProfile;
        }

        $this->viewData['list_access_data'] = '';
        $this->viewData['user_role'] = $user->id_role;
        $this->viewData['list_roles'] = Role::pluck('name', 'id')->all();

        if ( $user->id_role === Role::ROLE_JEMAAT ) {
            if ($userProfile) {
                $jemaatIndukID = (int) $userProfile->access_data['jemaat'];
                $userJemaatInduk = JemaatInduk::find( $jemaatIndukID);

                $jemaat_induk_list = JemaatInduk::where('id_mupel', $userJemaatInduk->id_mupel)->get();
                $this->viewData['list_access_data_mupel_selected'] = $userJemaatInduk->id_mupel;
            } else {
                $jemaat_induk_list = JemaatInduk::all();

                $this->viewData['list_access_data_mupel_selected'] = '';
            }


            $this->viewData['list_access_data_mupel'] = \App\Models\Mupel::pluck('nama', 'id')->all();
            
            $this->viewData['list_access_data'] = $jemaat_induk_list->pluck('nama', 'id')->all();
        } elseif ( $user->id_role === Role::ROLE_MUPEL ) {
            $mupel_list = \App\Models\Mupel::pluck('nama', 'id')->all();

            $this->viewData['list_access_data'] = $mupel_list;
        }

        $this->viewData['user'] = $user;
        $this->viewData['page_title'] = 'Data Profile User';

        return view('users.profile', $this->viewData);
    }

    public function profileStore( \App\Http\Requests\CreateProfileRequest $request, $id)
    {
        $request->validated();
        $validatedData = $request->formatInput();

        DB::table('user_roles')->where('id_user', $id)->update([
            'id_role' => $validatedData['id_role'],
            "updated_at" => date('Y-m-d H:i:s', time())
        ]);

        unset($validatedData['id_role']);
        $userProfile = Profile::firstOrNew(['id_user' => $id], $validatedData);
        
        if ($userProfile) {
            foreach ($validatedData as $key => $value) {
                $userProfile->{$key} = $value;
            }

            $userProfile->id_user = $id;
        }

        $userProfile->save();

        return redirect()->route('users.index')->with('status', 'Data Profil User berhasil diupdate.');
    }

    public function showChangePasswordForm()
    {
        return view('users.password');
    }

    public function changePassword(Request $request)
    {
        if ( !Hash::check($request->get('password_lama'), $this->userSession->password) ) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('password_lama'), $request->get('password_baru')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $this->validate($request, [
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:6|confirmed',
            'password_baru_confirmation' => 'required|min:6'
        ], [
            'required' => 'The :attribute field is required',
        ]);

        //Change Password
        $this->userSession->password = bcrypt($request->get('password_baru'));
        $this->userSession->pass_prompt = "0";
        $this->userSession->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function getMupelJematByRole(Request $request)
    {
        $input = $request->only(['inputVal']);
        $inputVal = $input['inputVal'];
        $response = [];
        $response['input_template'] = '';
        $response['role_selected'] = '';
        // dd($inputVal);

        if ( $inputVal == Role::ROLE_JEMAAT ) {
            $mupel_list = \App\Models\Mupel::pluck('nama', 'id')->all();
            $jemaat_induk_list = JemaatInduk::pluck('nama', 'id')->all();
            
            $response['role_selected'] = 'jemaat';
            $response['input_template'] = 
                                    '<div class="form-group m-form__group">' .
                                        Form::label("mupel", "Pilih Mupel", ["class" => "control-label"]) .
                                        Form::select("mupel", $mupel_list, null, ["class" => "form-control m-input m-input--square select2", 'id' => "m_select2_2", "placeholder" => "Mupel"]) .
                                        // $errors->first("mupel", "<p class=\'help-block\'>:message</p>") 
                                    '</div>' 
                                    .
                                    '<div class="form-group m-form__group">' .
                                        Form::label("jemaat", "Pilih Jemaat", ["class" => "control-label"]) .
                                        Form::select("jemaat", $jemaat_induk_list, null, ["class" => "form-control m-input m-input--square select2", 'id' => "m_select2_3", "placeholder" => "Jemaat"]) .
                                        // $errors->first("mupel", "<p class=\'help-block\'>:message</p>") 
                                    '</div>';
        } elseif ( $inputVal == Role::ROLE_MUPEL ) {
            $mupel_list = \App\Models\Mupel::pluck('nama', 'id')->all();
            $response['role_selected'] = 'mupel';

            $response['input_template'] = 
                                    '<div class="form-group m-form__group">' .
                                        Form::label("mupel", "Pilih Mupel", ["class" => "control-label"]) .
                                        Form::select("mupel", $mupel_list, null, ["class" => "form-control m-input m-input--square select2", 'id' => "m_select2_1", "placeholder" => "Mupel"]) .
                                        // $errors->first("mupel", "<p class=\'help-block\'>:message</p>") . 
                                    '</div>';
        }

        return response()->json($response);
    }
}