<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\administrator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;


class AdminAdd extends Controller
{
    public function add(Request $req){

        /* $this->validate($req,[
            'fname' => 'required',
            'lname' => 'required'
        ]); */
        /* $fname= $req['fname'];
        $lname= $req['lname'];
        $email= $req['email'];
        $contact= $req['contact'];
        $dob= $req['dob'];
        $address= $req['address'];
        $propic= $req['propic'];
        $pass= $req['pass']; */

        $admin= new administrator(
            ['first_name' => $req->get('fname'),'last_name' => $req->get('lname'),'profile_photo' => $req->get('propic'),'email' => $req->get('email'),'date_of_birth' => $req->get('dob'),'phone_number'=> $req->get('contact'),'address' => $req->get('address'),'password' => $req->get('pass') ]
        );
        $admin->save();
        
        /* $connection=mysqli_connect("localhost","root","");
        $db=mysqli_select_db($connection,'lak_market'); */

        /* if(isset($_POST['savedata']))
        { */
           /*  $fname= $req['fname'];
            $lname= $req['lname'];
            $email= $req['email'];
            $contact= $req['contact'];
            $dob= $req['dob'];
            $address= $req['address'];
            $propic= $req['propic'];
            $pass= $req['pass'];

            $query= "INSERT INTO administrators ("first_name","last_name","profile_photo","email","phone_number","date_of_birth","address","password") VALUES ("$fname","$lname","$propic","$email","$contact","$dob","$address","$pass")";
            $query_run=mysqli_query($connection,$query); */

            if($admin)
            {
                echo '<script> alert("Data saved"); </script>';
                return redirect('admin/dashboard/admins');
            }
            else
            {
                echo '<script> alert("Data not saved"); </script>';       
            }
        }
    }

