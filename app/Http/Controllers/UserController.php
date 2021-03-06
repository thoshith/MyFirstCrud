<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function sendResponse($success, $result, $message, $response_code)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $response_code);
    }

    public function showAll(Request $request)
    {
        Log::info('Display all users: ');
        $limit = $request->query('limit', 200);
        try {
            $res = DB::select('select count(*) as total from users');
            Log::info('Total number of users' . $res[0]->total);
            $total_users = $res[0]->total;
            if ($total_users > $limit) {
                $user_list = DB::select('select * from users limit ?', [$limit]);
            } else {
                $user_list = DB::select('select * from users');
            }
        } catch (\PDOException $pex) {
            Log::critical('some error: ' . print_r($pex->getMessage(), true)); //xampp off
            return $this->sendResponse("false", "", 'error related to database', 500);
        } catch (\Exception $e) {
            Log::critical('some error: ' . print_r($e->getMessage(), true));
            Log::critical('error line: ' . print_r($e->getLine(), true));
            return $this->sendResponse("false", "", 'some error in server', 500);
        }
        return $this->sendResponse("true", $user_list, 'request completed', 200);
    }

    public function showOne(Request $req, $ph)
    {
        if ($ph > 0) {
            try {
                Log::info('Showing user details of : ' . $ph);
                $user_id = DB::select('select uid from users where phone = ?', [$ph]);
            } catch (\PDOException $pex) {
                Log::critical('some error: ' . print_r($pex->getMessage(), true)); //xampp off
                return $this->sendResponse("false", "", 'error related to database', 500);
            } catch (\Exception $e) {
                Log::critical('some error: ' . print_r($e->getMessage(), true));
                Log::critical('error line: ' . print_r($e->getLine(), true));
                return $this->sendResponse("false", "", 'some error in server', 500);
            }
        } else {
            return $this->sendResponse("false", "", 'some error in user id', 500);
        }
        return $this->sendResponse("true", $user_id, 'request completed', 200);
    }

    public function insert(Request $request)
    {
        if ($request->has('uname') && $request->has('phone') && $request->has('location')) {
            $user_name = $request->input('uname');
            $phone_num = $request->input('phone');
            $location  = $request->input('location');
            try {
                $resp = DB::insert('insert into users (uname,phone,location) values (?,?,?)', [$user_name, $phone_num, $location]);
                Log::info('Inserted new user: ' . $resp);
            } catch (\PDOException $pex) {
                Log::critical('some error: ' . print_r($pex->getMessage(), true)); //xampp off
                return $this->sendResponse("false", "", 'error related to database', 500);
            } catch (\Exception $e) {
                Log::critical('some error: ' . print_r($e->getMessage(), true));
                Log::critical('error line: ' . print_r($e->getLine(), true));
                return $this->sendResponse("false", "", 'some error in server', 500);
            }
        } else {
            Log::warning('input data missing' . print_r($request->input('uname'), true));
            return $this->sendResponse("", 'incorrect request', 500); //wrong field name
        }
        return $this->sendResponse("true", $resp, 'data insereted successfully', 201);
    }

    public function edit(Request $request, $user_id)
    {
        if ($request->has('phone') && $request->has('location')) {
            $phone    = $request->input('phone');
            $location = $request->input('location');
            if ($user_id > 0 && $user_id < 20) {
                try {
                    $resp = DB::update('update users set  phone = ?, location = ? where uid = ?', [$phone, $location, $user_id]);
                } catch (\PDOException $pex) {
                    Log::critical('some error: ' . print_r($pex->getMessage(), true)); //xampp off
                    return $this->sendResponse("false", "", 'error related to database', 500);
                } catch (\Exception $e) {
                    Log::critical('some error: ' . print_r($e->getMessage(), true));
                    Log::critical('error line: ' . print_r($e->getLine(), true));
                    return $this->sendResponse("false", "", 'some error in server', 500);
                }
            }
        } else {
            return $this->sendResponse("false", "", 'some error in input', 500);
        }
        Log::info('Updated user deatils: ' . $user_id);
        return $this->sendResponse("true", $resp, 'data updated', 200);
    }

    public function destroy($user_id)
    {
        if ($user_id > 0 && $user_id <= 20) {
            try {
                Log::info('Deleted user : ' . $user_id);
                $resp = DB::delete('delete from users where uid = ?', [$user_id]);
            } catch (\PDOException $pex) {
                Log::critical('some error: ' . print_r($pex->getMessage(), true)); //xampp off
                return $this->sendResponse("false", "", 'error related to database', 500);
            } catch (\Exception $e) {
                Log::critical('some error: ' . print_r($e->getMessage(), true));
                Log::critical('error line: ' . print_r($e->getLine(), true));
                return $this->sendResponse("false", "", 'some error in server', 500);
            }
        } else {
            return $this->sendResponse("false", "", 'some error in input', 500);
        }
        return $this->sendResponse("true", $resp, 'request completed', 200);
    }
}
