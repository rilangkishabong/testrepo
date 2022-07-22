<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail as FacadesMail;
class SendEmailController extends Controller
{

    public function sendEmail()
    {
        $data = array(
            'name'      =>  "JACK",
            // 'contacts'   =>   $request->input('ynm'),
            // 'emailid' => $request->input('yeml'),
            // 'msg' => $request->input('ymsg')
        );
      FacadesMail::to('pynmaw@gmail.com')->send(new NotifyMail($data));

      if (FacadesMail::failures()) {
           //return response()->Fail('Sorry! Please try again latter');
           dd("Failed");
      }else{
           //return response()->success('Great! Successfully send in your mail');
           dd("Sent Successfully");
         }
    }
}
