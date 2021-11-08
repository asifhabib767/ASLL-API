<?php

namespace Modules\Auth\Repositories;

use App\Helpers\StringHelper;
use App\Models\Project;
use App\Repositories\ResponseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Auth\Entities\User;
use Modules\Auth\Entities\UserApps;
use Modules\Auth\Entities\UserERP;
use Modules\Auth\Interfaces\AuthInterface;

use Adldap\AdldapInterface;
use Adldap\Laravel\Facades\Adldap;
use GuzzleHttp\Client as GuzzleHttpClient;
use Laravel\Passport\Client;
use Modules\PSD\Entities\PromotionProgramType;

class AuthRepository implements AuthInterface
{
    // /**
    //  * @var Adldap
    //  */
    // protected $ldap;

    // /**
    //  * Constructor.
    //  *
    //  * @param AdldapInterface $adldap
    //  */
    // public function __construct(AdldapInterface $ldap)
    // {
    //     $this->ldap = $ldap;
    // }


    /**
     * check if user is authenticated
     *
     * @param Request $request
     * @return boolean
     */
    public function checkIfAuthenticated(Request $request)
    {
        $user = $this->findUserByEmailAddress($request->email);

        if (!is_null($user)) {
            if (Hash::check($request->password, $user->password)) {
                return true;
            }
        }
        return false;
    }

    /**
     * check if authenticated by external user
     *
     * @param Request $request
     * @return void
     */
    public function checkIfAuthenticatedByExternalUser($username, $password)
    {
        $username = trim($username);
        $password = trim($password);

        $query = DB::table(config('constants.DB_Apps') . ".tblAppsUserIDNPasswd")
            ->leftJoin(config('constants.DB_Apps') . ".tblAppsUserType", 'tblAppsUserType.intId', '=', 'tblAppsUserIDNPasswd.intUserTypeID')
            ->leftJoin(config('constants.DB_HR') . ".tblEmployee", 'tblAppsUserIDNPasswd.intEnrol', '=', 'tblEmployee.intEmployeeID')
            ->leftJoin(config('constants.DB_HR') . ".tblUserDesignation", 'tblEmployee.intDesignationID', '=', 'tblUserDesignation.intDesignationID')
            ->leftJoin(config('constants.DB_HR') . ".tblDepartment", 'tblEmployee.intDepartmentID', '=', 'tblDepartment.intDepartmentID')
            ->leftJoin(config('constants.DB_SAD') . ".tblCustomer", 'tblCustomer.intCusID', '=', 'tblAppsUserIDNPasswd.intCustomerID');

        $query->where(function ($query) use ($username) {
            $query->where('tblAppsUserIDNPasswd.strUserName', '=', $username);
            if (is_numeric($username)) {
                $query->orWhere('tblAppsUserIDNPasswd.intEnrol', '=', $username);
            }
            // $query->orWhere('tblAppsUserIDNPasswd.strPhone', '=', $username)
            //     ->orWhere('tblAppsUserIDNPasswd.strUserEmail', '=', $username);
        });

        $query->select(
            'tblAppsUserIDNPasswd.*',
            'tblAppsUserType.strUserType',
            'tblCustomer.intPriceCatagory as customerTerritoryID',
            'tblCustomer.intSalesOffId as customerSalesOfficeId',
            'tblUserDesignation.strDesignation',
            'tblEmployee.intDesignationID',
            'tblEmployee.intJobStationId',
            'tblEmployee.strEmployeeCode',
            'tblEmployee.intSuperviserId',
            'tblEmployee.intDepartmentID',
            'tblDepartment.strDepatrment',
        );
        $output = $query->first();
        // $query->where('strPasswd', $password);

        if (!is_null($output)) {
            if ($output->strPasswd != $password) {
                if (!Hash::check($password, $output->strHashPassword)) {
                    return null;
                }
            }
        }
        return $output;
    }



    /**
     * register user
     *
     * @param Request $request
     * @return object $user
     */
    public function registerUser(Request $request)
    {
        $username = StringHelper::createSlug($request->first_name, 'Modules\Auth\Entities\User', 'username', '');

        $user = User::create(
            [
                'first_name'  => $request->first_name,
                'surname'  => $request->surname,
                'last_name'  => $request->last_name,
                'username'  => $username,
                'email'  => $request->email,
                'phone_no'  => $request->phone_no,
                'password'  => Hash::make($request->password),
                'language' => $request->language ? $request->language :  'en'
            ]
        );
        return $user;
    }

    /**
     * find User By Email Address
     *
     * @param string $email
     * @return object $user
     */
    public function findUserByEmailAddress($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }

    /**
     * find User By Phone No
     *
     * @param string $phone_no
     * @return object $user
     */
    public function findUserByPhoneNo($phone_no)
    {
        $user =  User::where('phone_no', $phone_no)->first();
        return $user;
    }

    /**
     * find User by ID
     *
     * @param integer $id
     * @return object $user
     */
    public function findUserById($id)
    {
        $user =  User::find($id);
        return $user;
    }


    /**
     * update User Profile
     *
     * @param Request $request
     * @param integer $id
     * @return object $user
     */
    public function updateUserProfile(Request $request, $id)
    {
        $user = $this->findUserById($id);
        DB::table("users")
            ->where('id', $id)
            ->update(
                [
                    'first_name'  => $request->first_name,
                    'surname'  => $request->surname,
                    'last_name'  => $request->last_name,
                    'username'  => $request->username,
                    'email'  => $request->email,
                    'phone_no'  => $request->phone_no,
                    'password'  => $request->password ? Hash::make($request->password) : $user->password,
                    'language' => $request->language ? $request->language :  'en'
                ]
            );

        return $this->findUserById($id);
    }

    /**
     * delete user by ID
     *
     * @param integer $id
     * @return object $user
     */
    public function deleteUserAccount($id)
    {
        $user =  $this->findUserById($id);
        DB::table("users")->where('id', $id)->delete();
        return $user;
    }

    /**
     * check User account
     *
     * @param integer $id
     * @return boolean  Returns true if User account exist else false
     */
    public function checkUserAccount($id)
    {

        $user = $this->findUserById($id);
        if (!is_null($user))
            return true;
        return false;
    }

    public function changePassword($username, $password)
    {
        $user = DB::table(config('constants.DB_Apps') . ".tblAppsUserIDNPasswd")
            ->where('strUserName', $username)
            ->first();

        if (!is_null($user)) {
            DB::table(config('constants.DB_Apps') . ".tblAppsUserIDNPasswd")
                ->where('intId', $user->intId)
                ->update([
                    'strPasswd' => $password
                ]);
        }
        $user = DB::table(config('constants.DB_Apps') . ".tblAppsUserIDNPasswd")
            ->where('strUserName', $username)
            ->first();
        return $user;
    }

    public function superUserLogin($username, $password)
    {
        // $user = Adldap::search()->users()->get();
        // return response(['data' => $user]);
        $data = [
            'isLoggedIn' => false,
            'user' => null,
            'access_token' => null,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()
        ];
        $responseRepository = new ResponseRepository();

        $email =  $username . '@akij.net';
        if (strpos($username, '@akij.net') !== false) {
            $email =  $username . '@akij.net';
        }

        $user = User::where('username', $username)->first();

        if (!is_null($user)) {
            $user->intUnitId = $user->business_id;
            if (Hash::check($password, $user->password)) {
                $data['isLoggedIn'] = true;
            } else {
                $userData = $this->getUserInformation($username, $password, $email);
                $data['isLoggedIn'] = $userData['isLoggedIn'];
                $data['user'] = $userData['user'];

            }
        } else {
            $userData = $this->getUserInformation($username, $password, $email);
            $data['isLoggedIn'] = $userData['isLoggedIn'];
            $data['user'] = $userData['user'];
        }
        if (!$data['isLoggedIn']) {
            return $responseRepository->ResponseError(null, 'Sorry, Invalid Username and Password');
        } else {
            $tokenCreated = $this->createTokenForUser($data['user']);
            $data['access_token'] = null;
            $data['expires_at'] = null;
            if(!is_null($tokenCreated)){
                $data['access_token'] = $tokenCreated->accessToken;
                $data['expires_at'] = $tokenCreated->token->expires_at;
            }
            return $responseRepository->ResponseSuccess($data, 'Logged in Successfully');
        }
    }


    public function getUserInformation($username, $password, $email)
    {

        // Check in AD authorization
        $user = null;
        $data['isLoggedIn'] = $this->checkInADAuthorized($username, $password);


        // If Response as true, then create a User Model with storing username and password or update
        if ($data['isLoggedIn']) {
            // Get the User data from ERP and set it to
            $erpUser = $this->getUserERPData($email);
            if (!is_null($erpUser)) {
                $user = $this->createOrUpdateMasterUser($username, Hash::make($password), $erpUser->strOfficeEmail, $erpUser->strContactNo1, $erpUser->strEmployeeName, $erpUser->intUnitID, $erpUser->intEmployeeID, 1);

                $user->strUserType = 'ERP User';
                $user->intEmployeeId = $erpUser->intEmployeeID;
                $user->strEmployeeCode = $erpUser->strEmployeeCode;
                $user->strEmployeeName = $erpUser->strEmployeeName;
                $user->intUnitId = (int) $erpUser->intUnitID;
                $user->intJobStationId = $erpUser->intJobStationID;
                $user->intJobTypeId = $erpUser->intJobTypeId;
                $user->strOfficeEmail = $erpUser->strOfficeEmail;
                $user->strContactNo1 = $erpUser->strContactNo1;
                $user->strJobStationName = $erpUser->strJobStationName;
                $user->strPermanentAddress = $erpUser->strPermanentAddress;
                $user->strPresentAddress = $erpUser->strPresentAddress;
                $user->strAlias = $erpUser->strAlias;
                $user->strCountry = $erpUser->strCountry;
                $user->strCity = $erpUser->strCity;
                $user->dteBirth = $erpUser->dteBirth;
                $user->strDescription = $erpUser->strDescription;
                $user->strJobType = $erpUser->strJobType;
                $user->strDistrict = $erpUser->strDistrict;
                $user->strManager = $erpUser->strManager;
                $user->strDesignation = $erpUser->strDesignation;
                $user->strDepatrment = $erpUser->strDepatrment;

                $user->intUserTypeID = 1;
            }
        } else {
            // If Response as false, Check in ERP_Apps table with Username and Password
            $appUser = $this->getUserAppsData($username);
            $intUserTypeID = $appUser->intUserTypeID;
            if($intUserTypeID == 5){
                $intEnrol = $appUser->intCustomerID;
            }else if($intUserTypeID == 2){
                $intEnrol = $appUser->intSupplierID;
            }else{
                $intEnrol = $appUser->intEnrol;
            }

            if (!is_null($appUser)) {
                $data['isLoggedIn'] = $this->checkInAppsAuthorized($username, $password);
                if ($data['isLoggedIn']) {
                    $user = $this->createOrUpdateMasterUser($username, Hash::make($password), $appUser->strUserName, $appUser->strPhone, $appUser->strName, $appUser->intUnitId, $intEnrol, $appUser->intUserTypeID);

                    $user->intUserID = $appUser->intUserID;
                    $user->strEmployeeCode = $appUser->strEmployeeCode;
                    $user->intEmployeeId = (int) $appUser->intEmployeeID;
                    $user->strName = $appUser->strName;
                    $user->intUnitId = (int) $appUser->intUnitId;
                    $user->intJobStationId = $appUser->intJobStationId;
                    $user->strOfficeEmail = $appUser->strOfficeEmail;
                    $user->strPhone = $appUser->strPhone;
                    $user->strUserName = $appUser->strUserName;
                    $user->strCountry = 'Bangladesh';
                    $user->intSuperviserId = $appUser->intSuperviserId;
                    $user->strDesignation = $appUser->strDesignation;
                    $user->strDepatrment = $appUser->strDepatrment;
                    $user->api_token = $appUser->api_token;
                    $user->employee = $appUser->employee;
                    $user->intUserTypeID = $appUser->intUserTypeID;
                    $user->strUserType = $appUser->strUserType;
                    $user->ysnOwnUser = $appUser->ysnOwnUser;
                    $user->customerTerritoryID = $appUser->customerTerritoryID;
                    $user->customerSalesOfficeId = $appUser->customerSalesOfficeId;
                }
            }
        }
        $data['user'] = $user;
        return $data;
    }

    public function checkInADAuthorized($username, $password)
    {
        // $response = Http::get('http://api2.akij.net:8053/api/ADAuthorization/ADAuthorization?username=' . $username . '&password=' . $password);
        // $isLoggedIn = $response->json();
        // return $isLoggedIn;

        // New lDap Approach
        return Adldap::auth()->attempt('akij\\'.$username, $password, true);
    }

    public function checkInAppsAuthorized($username, $password)
    {
        $exists = UserApps::where('strUserName', $username)
            ->where('strPasswd',  $password)
            ->exists();
        return $exists;
    }

    public function createTokenForUser($user)
    {
        $tokenCreated = $user->createToken('authToken');
        return $tokenCreated;
    }

    public function getUserERPData($email)
    {
        return UserERP::where('strOfficeEmail', $email)
            ->leftJoin(config('constants.DB_HR') . ".tblUserDesignation", 'tblEmployee.intDesignationID', '=', 'tblUserDesignation.intDesignationID')
            ->leftJoin(config('constants.DB_HR') . ".tblDepartment", 'tblEmployee.intDepartmentID', '=', 'tblDepartment.intDepartmentID')
            ->select(
                'tblEmployee.*',
                'tblUserDesignation.strDesignation',
                'tblDepartment.strDepatrment',
            )
            ->first();

    }

    public function getUserAppsData($username)
    {
        return UserApps::where('strUserName', $username)
            ->leftJoin(config('constants.DB_Apps') . ".tblAppsUserType", 'tblAppsUserType.intId', '=', 'tblAppsUserIDNPasswd.intUserTypeID')
            ->leftJoin(config('constants.DB_HR') . ".tblEmployee", 'tblAppsUserIDNPasswd.intEnrol', '=', 'tblEmployee.intEmployeeID')
            ->leftJoin(config('constants.DB_HR') . ".tblUserDesignation", 'tblEmployee.intDesignationID', '=', 'tblUserDesignation.intDesignationID')
            ->leftJoin(config('constants.DB_HR') . ".tblDepartment", 'tblEmployee.intDepartmentID', '=', 'tblDepartment.intDepartmentID')
            ->leftJoin(config('constants.DB_SAD') . ".tblCustomer", 'tblCustomer.intCusID', '=', 'tblAppsUserIDNPasswd.intCustomerID')
            ->select(
                'tblAppsUserIDNPasswd.*',
                'tblEmployee.intEmployeeID',
                'tblAppsUserType.strUserType',
                'tblCustomer.intPriceCatagory as customerTerritoryID',
                'tblCustomer.intSalesOffId as customerSalesOfficeId',
                'tblUserDesignation.strDesignation',
                'tblEmployee.intDesignationID',
                'tblEmployee.intJobStationId',
                'tblEmployee.strEmployeeCode',
                'tblEmployee.intSuperviserId',
                'tblEmployee.intDepartmentID',
                'tblDepartment.strDepatrment',
            )
            ->first();
    }

    public function createOrUpdateMasterUser($username, $password, $email, $phone_no, $first_name, $business_id, $intEnrol, $intUserTypeID)
    {
        return User::updateOrCreate(
            ['username' => $username],
            [
                'intEnroll' => $intEnrol,
                'business_id' => $business_id,
                'first_name'  => $first_name,
                'surname'  => null,
                'last_name'  => null,
                'username'  => $username,
                'email'  => $email,
                'phone_no'  => $phone_no,
                'password'  => Hash::make($password),
                'language' => 'en',
                'intUserTypeID' => $intUserTypeID,
            ]
        );
    }

    public function externalUserLogin($username, $password)
    {
        // $user = Adldap::search()->users()->get();
        // return response(['data' => $user]);
        $data = [
            'isLoggedIn' => false,
            'user' => null,
            'access_token' => null,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()
        ];
        $responseRepository = new ResponseRepository();

        $email =  $username . '@akij.net';
        if (strpos($username, '@akij.net') !== false) {
            $email =  $username . '@akij.net';
        }

        $user = User::where('username', $username)->first();

        if (!is_null($user)) {
            $user->intUnitId = $user->business_id;
            if (Hash::check($password, $user->password)) {
                $data['isLoggedIn'] = true;
            } else {
                $userData = $this->getUserInformation($username, $password, $email);
                $data['isLoggedIn'] = $userData['isLoggedIn'];
                $data['user'] = $userData['user'];

            }
        } else {
            $userData = $this->getUserInformation($username, $password, $email);
            $data['isLoggedIn'] = $userData['isLoggedIn'];
            $data['user'] = $userData['user'];
        }
        if (!$data['isLoggedIn']) {
            return $responseRepository->ResponseError(null, 'Sorry, Invalid Username and Password');
        } else {
            $tokenCreated = $this->createTokenForUser($data['user']);
            $data['access_token'] = null;
            $data['expires_at'] = null;
            if(!is_null($tokenCreated)){
                $data['access_token'] = $tokenCreated->accessToken;
                $data['expires_at'] = $tokenCreated->token->expires_at;
            }
            return $responseRepository->ResponseSuccess($data, 'Logged in Successfully');
        }
    }

    public function getTokenAndRefreshToken($email, $password) {
        $oClient = Client::first();
        $http = new GuzzleHttpClient();
        $response = $http->request('POST', 'http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $this->successStatus);
    }

}
