<?php

namespace App\Http\Controllers;

use App\BankAccount as BankAccount;
use App\User as User;
use Illuminate\Http\Request;
use JavaScript;
use Mockery\Exception;
use View;

class BankController extends Controller
{
    use CreatesModels;

    public function createNewAccount(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);

        // FIXME return error response with status and message in case of errors
        $account = $this->newBankAccount($data, $user);

        if($data['set_primary']) {
            $user->active_bank_account_id = $account->id;
            $user->save();
        }
        return response([
            'bank_account' => $account,
            'status' => 'success',
            'message' => 'Conto correttamente registrato',
            'redirect' => route('view.user', ['id' => $account->user_id])
        ], 200);
    }
}
