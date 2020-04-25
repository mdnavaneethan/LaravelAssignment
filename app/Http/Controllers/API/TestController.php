<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeWebHistory;

class TestController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function test()
    {
        $employee = Employee :: all();
        return response()->json(["employee" => $employee], 200);
    }

    public static function addEmployee($values)
    {
        $employee = new Employee;
        $employee->emp_id       = $values[2];
        $employee->emp_name     = $values[3];
        $employee->ip_address   =$values[4];
        $employee->save();
        echo "employee inserted successfully";

    }

    public static function getEmployee($values)
    {
        $employee = Employee::where('ip_address',$values[2])->get();
        if(count($employee) == 0){
            echo "NULL";
            return;
        }
        echo response()->json(["employee" => $employee], 200);
    }

    public static function delEmployee($values)
    {
        $employee = Employee::where('ip_address',$values[2])->delete();
        echo "Employee deleted successfully";
    }

    public static function addEmpWebHistory($values)
    {
        $webhistory = new EmployeeWebHistory;
        $webhistory->ip_address  = $values[2];
        $webhistory->url         = $values[3];
        $webhistory->date        = date('Y-m-d');
        $webhistory->save();
        echo "employee web history inserted successfully";
    }

    public static function getEmpWebHistory($values)
    {
        // $employee = EmployeeWebHistory::select('ip_address', DB::raw('group_concat(url) as urls'))->groupBy('ip_address')->where('ip_address',$values[2])->get();

        $employee = EmployeeWebHistory::select('ip_address','url')->where('ip_address',$values[2])->get()->toArray();

        $array_value = array_column($employee, 'url');
        $array_url = [];
        foreach($array_value as $key => $val){
            $array_url[]['url'] = $array_value[$key];
        }
        $empWebHistory = ['ip_address'=>$values['2'],'urls'=>$array_url];
        if(count($employee) == 0){
            echo "NULL";
            return;
        }
        echo response()->json(["employee" => $empWebHistory], 200);
    }

     public static function delEmpWebHistory($values)
    {
        $empHistory = EmployeeWebHistory::where('ip_address',$values[2])->delete();
        echo "Employee history deleted successfully";
    }
}