<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'country' => ['required', 'string', 'max:50'],
            'province' => ['required', 'string', 'max:50'],
            'regency' => ['required', 'string', 'max:50'],
            'district' => ['required', 'string', 'max:50'],
            'subdistrict' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:150'],
            'telephone' => ['required', 'string', 'max:20'],
            'handphone' => ['required', 'string', 'max:20'],
            'director' => ['required', 'string', 'max:50'],
            'position' => ['required', 'string', 'max:50'],
            'handphone_director' => ['required', 'string', 'max:20'],
            'person_in_charge' => ['required', 'string', 'max:50'],
            'handphone_person_in_charge' => ['required', 'string', 'max:20'],
            'imprint' => ['nullable'],
            'publisher' => ['nullable'],
            'category' => ['nullable'],
            'npwp' => ['nullable'],
            'account_bank' => ['required'],
            'bank' => ['required'],
            'account_name' => ['required'],
            'bank_city' => ['required'],
            'supplier' => ['required'],
            'distributor' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $client_id = Str::uuid();
        
        DB::table('tclient')->insert([
            'id' => $client_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'country' => $data['country'],
            'province' => $data['province'],
            'regency' => $data['regency'],
            'district' => $data['district'],
            'subdistrict' => $data['subdistrict'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'telephone' => $data['telephone'],
            'handphone' => $data['handphone'],
            'director' => $data['director'],
            'position' => $data['position'],
            'handphone_director' => $data['handphone_director'],
            'pic' => $data['person_in_charge'],
            'handphone_pic' => $data['handphone_person_in_charge'],
            'file' => '',
            'type' => ($data['supplier'] && $data['distributor']) ? '3' : ((!$data['supplier'] && $data['distributor']) ? '2' : '1'),
            'created_at' => Carbon::now('Asia/Jakarta'),
            'created_by' => $data['email'],
            'updated_at' => Carbon::now('Asia/Jakarta'),
            'updated_by' => $data['email'],
        ]);

        foreach ($data['imprint'] as $key => $value) {
            DB::table('tpublisher')->insert([
                'client_id' => $client_id,
                'id' => Str::uuid(),
                'description' => $value['name'],
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        foreach ($data['publisher'] as $key => $value) {
            DB::table('tclient_authorizing')->insert([
                'client_id' => $client_id,
                'author_id' => Str::uuid(),
                'author_desc' => $value['name'],
                'created_at' => $data['email'],
                'created_by' => Carbon::now('Asia/Jakarta'),
                'updated_at' => $data['email'],
                'updated_by' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        foreach ($data['category'] as $key => $value) {
            DB::table('tclient_category')->insert([
                'client_id' => $client_id,
                'category_id' => $value['id'],
                'category_desc' => $value['desc'],
                'created_at' => $data['email'],
                'created_by' => Carbon::now('Asia/Jakarta'),
                'updated_at' => $data['email'],
                'updated_by' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'client_id' => $client_id
        ]);
    }
}
