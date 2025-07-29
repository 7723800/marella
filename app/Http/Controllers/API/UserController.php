<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\PhoneValidationRule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', $this->request->id)->with('order.items')->firstOrFail();
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Verify user login and password.
     *
     * @return \Illuminate\Http\Response
     */
    public function auth()
    {
        if (Auth::attempt(['email'=> $this->request->login , 'password' => $this->request->password], true))
        {
            $validator = Validator::make($this->request->all(), [
                'phone' => [new PhoneValidationRule],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'newPassword' => 'min:8',
            ]);
            return $validator->fails() ? $validator->errors() : array('success' => array('email' => $this->request->login));
        }
        return array('error' => array('Пароль не верный.'));
    }

    /**
     * Update user data in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $checkAuth = $this->auth();
        $isSuccess = Arr::exists($checkAuth, 'success');
        if($isSuccess) {
            $user = User::where('email', $checkAuth['success']['email'])->first();
            $user->name = $this->request->name;
            $user->lastname = $this->request->lastname;
            $user->city = $this->request->city;
            $user->area = $this->request->area;
            $user->address = $this->request->address;
            if ($this->request->has('email')) $user->email = $this->request->email;
            if ($this->request->has('phone')) $user->phone = $this->request->phone;
            $user->save();
            return response()->json(['success' => 'Ваши данные обновлены.']);
        }
        return response()->json($checkAuth);
    }

    /**
     * Update user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $checkAuth = $this->auth();
        $isSuccess = Arr::exists($checkAuth, 'success');
        if ($isSuccess) {
            $user = User::where('email', $checkAuth['success']['email'])->first();
            $user->password = Hash::make($this->request->newPassword);
            $user->save();
            return response()->json(['success' => 'Ваш пароль изменен.']);
        }
        return response()->json($checkAuth);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Verify user email and password before login.
     *
     * @return \Illuminate\Http\Response
     */
    protected function login()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (auth()->attempt(array('email' => $this->request->email, 'password' => $this->request->password), true))
            {
                return response()->json('success');
            }
            return response()->json(['error'=>'Неверный email или пароль.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
