<?php

namespace App\Http\Controllers;

use App\Models\Forma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function usersListShow()
    {
        return view('userList');
    }

    public function usersListDatatable(Request $request)
    {
        $result['data'] = [];

        if (Auth::user()->role == 1)
        {
            $allDataUser = User::all();

            if (count($allDataUser) > 0)
            {
                foreach ($allDataUser as $single)
                {
                    $tableData = [];
                    $tableData[] = $single->name;
                    if ($single->surname != null)
                    {
                        $tableData[] = $single->surname;
                    }
                    else
                    {
                        $tableData[] = "Nepateikta";
                    }
                    if ($single->city != null)
                    {
                        $tableData[] = $single->city;
                    }
                    else
                    {
                        $tableData[] = "Nepateikta";
                    }
                    $tableData[] = $single->email;
                    $tableData[] = $single->created_at->toDateString();
                    if ($single->phone_number != null)
                    {
                        $tableData[] = $single->phone_number;
                    }
                    else
                    {
                        $tableData[] = "Nepateikta";
                    }
                    $tableData[] = $single->id;
                    $result['data'][] = $tableData;
                }
            }
            $result['success'] = true;
            $result['recordsTotal'] = count($allDataUser);
            $result['recordsFiltered'] = count($result['data']);
            $result['draw'] = $request->draw;
            return response()->json($result);
        }
        else
        {
            return redirect()->back()->with('error', 'Šis funkcionalumas jums neprieinamas');
        }
    }
    public function userEditShow($id)
    {
        $userInfo = User::findOrFail($id);
        return view('userEditShow', compact('userInfo'));
    }
    public function userEdit(Request $request, $id)
    {
        $this->validate($request,             [
            'name' => 'required | max:32',
            'surname' => 'required | max:32',
            'phoneNumber' => 'required',
            'city' => 'required | max:32',
        ]);

        $profileForm = Auth::user();
        $profileForm->name = $request->name;
        $profileForm->surname = $request->surname;
        $profileForm->phone_number = $request->phoneNumber;
        $profileForm->city = $request->city;
        $profileForm->profile_verified = 1;
        $profileForm->save();
        return redirect()->route('profile')->with('success', 'Profilis sėkmingai užpildytas');
    }
}
