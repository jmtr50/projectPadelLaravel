<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
   

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'phone' =>'digits:9',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * crea un nuevo usuario después de la validación
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }



    /**
     * valida en login del usuario
     *
     * @param Request $request
     *
     * @return vista home
     */
    public function webLoginPost(Request $request)
    {
        $usuario =User::where("email","=",$request->input('email') )->first();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(!$usuario){
            return back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([$this->loginUsername() => 'Credentials not found']);
        }
        if($usuario->enabled == 'disabled') {
            return back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([$this->loginUsername() => 'User disabled temporally']);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
                return view('home');
        }else{
            return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([$this->loginUsername() => $this->getFailedLoginMessage(),]);
        }
    }


    
    
}