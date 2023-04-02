<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetPasswordRequest', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('email', 'password');

        $user = User::where('email', '=', $request->get('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email not found..',
                'errors' => [
                    "email" => ['Email not found..']
                ]

            ], 404);
        }

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Password is incorrect',
                'errors' => [
                    "password" => ['Password is incorrect']
                ]

            ], 406);
        }

        return response()->json(['status' => true, 'token' => $token]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = DB::table('users')->where('email', '=', $request->get('email'))->count();

        if ($user > 0) {
            return response()->json([
                'message' => 'Email already in use.',
                'errors' => [
                    "email" => ['Email already in use.']
                ]

            ], 409);
        }

        $newUser = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = Auth::login($newUser);

        return response()->json(['status' => true, 'token' => $token]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function newTask(Request $request)
    {
        $task = Tasks::create([
            'task' => $request->get('task'),
            'checked' => false,
            'user_id' => Auth::user()->id
        ]);

        return response()->json($task);
    }

    public function getTasks()
    {
        $user_id = Auth::user()->id;

        $tasks = Tasks::where('user_id', "=", $user_id)->get();
        if ($tasks->count() > 0) {


            return response()->json($tasks);
        } else {
            return response()->json([]);
        }
    }

    public function updateTask(Request $request, $id)
    {

        $task = Tasks::find($id);

        if ($task) {
            $task->update([
                'checked' => $request->get('checked'),
            ]);

            return $this->getTasks();
        } else {
            return response()->json(['status' => 'error', 'message' => 'Task not found.']);
        }
    }

    public function deleteTask($id)
    {
        $task = Tasks::find($id);
        if ($task) {
            $task->delete();
        }

        $user_id = Auth::user()->id;

        return $this->getTasks();
    }

    public function resetPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->get('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'Email not found.'], 404);
        } else {
            $random = rand(111111, 999999);
            $user->verification_code = $random;

            if ($user->save()) {
                $userData = array(
                    'email' => $user->email,
                    'random' => $random
                );

                Mail::send('forgetPasswordMail', $userData, function ($message) use ($userData) {
                    $message->from('no-reply@gmail.com');
                    $message->to($userData['email']);
                    $message->subject('Reset Password');
                });

                return response()->json(['message' => "We have sent a verification code to your email address."], 200);
            } else {
                return response()->json(['message' => "Some error ocurred, please try again."], 500);
            }
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::where('email', $request->get('email'))->where('verification_code', $request->get('verification_code'))->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid code'], 401);
        } else {
            $user->password = bcrypt($request->get('password'));
            $user->verification_code = null;


            if ($user->save()) {
                return response()->json(['message' => "Password changed successfuly"], 200);
            } else {
                return response()->json(['message' => "Some error ocurred, please try again"], 500);
            }
        }
    }
}
