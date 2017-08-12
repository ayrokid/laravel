<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination;
use App\User;
use App\Contact;

/**
* Ivo Class
*/
class IvoController extends Controller
{
	
	function __construct()
	{
		# code...
	}

	public function index()
	{
		$limit      = (Input::get('limit') ? Input::get('limit') : 10);

        if($limit >= 100) {
            $limit = 100;
        }

        return Contact::paginate($limit)->withPath('/');
	}

	/**
	 * Post Data User
	 * @param  Request $req [data user]
	 * @return [type]       [json]
	 */
	public function save(Request $request)
	{
		$firstname 	= trim($request->input('firstname'));
		$lastname 	= trim($request->input('lastname'));
		$address 	= trim($request->input('address'));
		$email 		= trim($request->input('email'));
		$phone 		= trim($request->input('phone'));
		$id 		= $request->input('id');

		if($firstname == null)
		{
			$res['success'] = false;
			$res['message'] = 'Your Firstname empty';

			return response()->json($res);
		}

		if($email == null)
		{
			$res['success'] = false;
			$res['message'] = 'Your Email incorrect!';

			return response()->json($res);
		}

		if($phone == null)
		{
			$res['success'] = false;
			$res['message'] = 'Your Phone Number incorrect!';

			return response()->json($res);
		}

		if($id == null) {
			$contact = new Contact();
			$contact->firstname = $firstname;
			$contact->lastname 	= $lastname;
			$contact->address 	= $address;
			$contact->email 	= $email;
			$contact->phone 	= $phone;
			$status = $contact->save();
		} else {
			$contact = Contact::findOrFail($id);
			$contact->firstname = $firstname;
			$contact->lastname 	= $lastname;
			$contact->address 	= $address;
			$contact->email 	= $email;
			$contact->phone 	= $phone;
			$status = $contact->save();
		}

		if($status) 
		{
			$res['status']	= true;
			$res['message'] = 'Successfully';
		}
		else
		{
			$res['status'] 	= false;
			$res['message'] = 'Filed to save';
		}

		return response()->json($res);
	}


	public function destroy($id)
	{
		$contact = Contact::findOrFail($id);
		if($contact)
		{
			$contact->delete();
			$res['status'] = true;
			$res['message'] = 'Successfully deleted';
		}
		else 
		{
			$res['status'] = false;
			$res['message'] = 'Cannot find data';
		}

		return response()->json($res);
	}

}