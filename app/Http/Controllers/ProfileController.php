<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\AllowedUser;

use DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function main() {
        return view("profile.main");
    }

    public function permission(Request $req, $action = null) {
        $ownerid      = Auth::id();

        $permissions  = DB::select(
            // DB::raw("select * from allowed_users 
            //         join quotation_corners on allowed_users.idfk = quotation_corners.quoteid 
            //         where quotation_corners.inputby = '{$ownerid}'")
            DB::raw(
                "select el.*, qc.* from emaillinkstbls as el 
                join quotation_corners as qc on el.idfk = qc.quoteid 
                where el.thetbl = 'allowed_users'"
            )
        );

        return view("profile.permission", compact("permissions"));
    }
}
